<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\Medicine;
use App\Models\MedicineStock;
use App\Models\StockOpname;
use App\Models\Warehouse;
use App\Models\WarehouseDispatch;
use App\Models\WarehouseItem;
use App\Models\WarehouseMutation;
use App\Models\WarehouseReceipt;
use App\Models\WarehouseStock;
use App\Models\WarehouseStockMovement;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WarehouseService
{
    /**
     * Data statistik agregat untuk dashboard gudang.
     */
    public function getDashboardMetrics(): array
    {
        $today = now()->toDateString();

        $totalItems = WarehouseItem::count();

        // Total Nilai Persediaan = SUM(stock * purchase_price)
        $totalInventoryValue = WarehouseStock::join('warehouse_items', 'warehouse_stocks.warehouse_item_id', '=', 'warehouse_items.id')
            ->selectRaw('SUM(warehouse_stocks.stock * warehouse_items.purchase_price) as total')
            ->value('total') ?? 0;

        $allItems = WarehouseItem::with('stocks')->get();

        // Item Hampir Habis (stock <= min_stock AND stock > 0)
        $lowStockCount = $allItems->filter(fn ($item) => $item->total_stock <= $item->min_stock && $item->total_stock > 0)->count();

        // Item Habis (total stock == 0)
        $outOfStockCount = $allItems->filter(fn ($item) => $item->total_stock <= 0)->count();

        // Barang Kedaluwarsa (expired_date <= 6 bulan kedepan)
        $expiringStockCount = WarehouseStock::where('expired_date', '<=', now()->addMonths(6))
            ->where('stock', '>', 0)
            ->count();

        // Inbound Hari Ini
        $todayReceiptCount = WarehouseReceipt::whereDate('receipt_date', $today)->count();

        // Outbound Hari Ini
        $todayDispatchCount = WarehouseDispatch::whereDate('dispatch_date', $today)->count();

        // Barang Hampir Habis List
        $lowStockItems = WarehouseItem::with(['stocks'])
            ->get()
            ->filter(fn ($item) => $item->total_stock <= $item->min_stock)
            ->take(6);

        // Barang Kedaluwarsa List
        $expiringStocks = WarehouseStock::with(['item', 'warehouse'])
            ->where('expired_date', '<=', now()->addMonths(6))
            ->where('stock', '>', 0)
            ->orderBy('expired_date')
            ->take(6)
            ->get();

        // Chart Data pergerakan 7 hari terakhir
        $movementLabels = [];
        $movementInData = [];
        $movementOutData = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $movementLabels[] = $date->translatedFormat('d M');
            $movementInData[] = (int) WarehouseStockMovement::whereDate('movement_date', $date->toDateString())
                ->where('movement_type', 'Masuk')
                ->sum('quantity');
            $movementOutData[] = (int) WarehouseStockMovement::whereDate('movement_date', $date->toDateString())
                ->where('movement_type', 'Keluar')
                ->sum('quantity');
        }

        return [
            'metrics' => [
                'totalItems' => $totalItems,
                'totalValue' => (float) $totalInventoryValue,
                'lowStockCount' => $lowStockCount,
                'outOfStockCount' => $outOfStockCount,
                'expiringCount' => $expiringStockCount,
                'todayReceiptCount' => $todayReceiptCount,
                'todayDispatchCount' => $todayDispatchCount,
            ],
            'charts' => [
                'labels' => $movementLabels,
                'inData' => $movementInData,
                'outData' => $movementOutData,
            ],
            'lowStockItems' => $lowStockItems,
            'expiringStocks' => $expiringStocks,
        ];
    }

    /**
     * Memproses Penerimaan Barang (Goods Receipt).
     */
    public function createReceipt(array $data): WarehouseReceipt
    {
        return DB::transaction(function () use ($data) {
            $receiptCount = WarehouseReceipt::whereYear('created_at', now()->year)->count() + 1;
            $receiptNumber = 'GRN-'.now()->format('Ymd').'-'.str_pad($receiptCount, 4, '0', STR_PAD_LEFT);

            $receipt = WarehouseReceipt::create([
                'receipt_number' => $receiptNumber,
                'receipt_date' => $data['receipt_date'],
                'warehouse_id' => $data['warehouse_id'],
                'supplier_id' => $data['supplier_id'] ?? null,
                'invoice_number' => $data['invoice_number'] ?? null,
                'total_amount' => 0,
                'notes' => $data['notes'] ?? null,
                'created_by' => Auth::id(),
            ]);

            $totalAmount = 0;

            foreach ($data['items'] as $itemData) {
                $item = WarehouseItem::findOrFail($itemData['warehouse_item_id']);
                $qty = (int) $itemData['quantity'];
                $price = (float) $itemData['purchase_price'];
                $batch = $itemData['batch_number'] ?? 'BATCH-'.now()->format('Ym');
                $expiredDate = $itemData['expired_date'] ?? null;
                $subtotal = $qty * $price;

                $receipt->items()->create([
                    'warehouse_item_id' => $item->id,
                    'quantity' => $qty,
                    'purchase_price' => $price,
                    'batch_number' => $batch,
                    'expired_date' => $expiredDate,
                    'subtotal' => $subtotal,
                ]);

                // Update WarehouseStock
                $stock = WarehouseStock::firstOrNew([
                    'warehouse_id' => $data['warehouse_id'],
                    'warehouse_item_id' => $item->id,
                    'batch_number' => $batch,
                ]);

                $stockBefore = (int) $stock->stock;
                $stock->stock = $stockBefore + $qty;
                if ($expiredDate) {
                    $stock->expired_date = $expiredDate;
                }
                $stock->save();

                // Log Movement
                WarehouseStockMovement::create([
                    'warehouse_id' => $data['warehouse_id'],
                    'warehouse_item_id' => $item->id,
                    'movement_date' => now(),
                    'movement_type' => 'Masuk',
                    'reference_number' => $receiptNumber,
                    'quantity' => $qty,
                    'stock_before' => $stockBefore,
                    'stock_after' => $stockBefore + $qty,
                    'notes' => 'Penerimaan Supplier '.$receiptNumber,
                    'user_id' => Auth::id(),
                ]);

                // Sync jika item terhubung dengan Medicine (Farmasi)
                if ($item->medicine_id) {
                    $med = Medicine::find($item->medicine_id);
                    if ($med) {
                        $med->update(['purchase_price' => $price]);
                        $medStock = MedicineStock::firstOrNew(['medicine_id' => $med->id, 'batch_number' => $batch]);
                        $medStock->stock = ($medStock->stock ?? 0) + $qty;
                        if ($expiredDate) {
                            $medStock->expired_date = $expiredDate;
                        }
                        $medStock->save();
                    }
                }

                $totalAmount += $subtotal;
            }

            $receipt->update(['total_amount' => $totalAmount]);

            ActivityLog::create([
                'user_id' => Auth::id(),
                'module' => 'Gudang',
                'action' => 'Penerimaan Barang',
                'description' => "Penerimaan barang baru {$receiptNumber} total Rp ".number_format($totalAmount, 0, ',', '.'),
            ]);

            return $receipt;
        });
    }

    /**
     * Memproses Pengeluaran Barang / Distribusi.
     */
    public function createDispatch(array $data): WarehouseDispatch
    {
        return DB::transaction(function () use ($data) {
            $dispatchCount = WarehouseDispatch::whereYear('created_at', now()->year)->count() + 1;
            $dispatchNumber = 'OUT-'.now()->format('Ymd').'-'.str_pad($dispatchCount, 4, '0', STR_PAD_LEFT);

            $dispatch = WarehouseDispatch::create([
                'dispatch_number' => $dispatchNumber,
                'dispatch_date' => $data['dispatch_date'],
                'source_warehouse_id' => $data['source_warehouse_id'],
                'destination_type' => $data['destination_type'],
                'destination_name' => $data['destination_name'],
                'status' => 'Selesai',
                'notes' => $data['notes'] ?? null,
                'created_by' => Auth::id(),
            ]);

            foreach ($data['items'] as $itemData) {
                $item = WarehouseItem::findOrFail($itemData['warehouse_item_id']);
                $qty = (int) $itemData['quantity'];
                $batch = $itemData['batch_number'] ?? 'DEFAULT';

                // Stock reduction from WarehouseStock
                $stockRecord = WarehouseStock::where('warehouse_id', $data['source_warehouse_id'])
                    ->where('warehouse_item_id', $item->id)
                    ->first();

                $currentStock = $stockRecord ? $stockRecord->stock : 0;
                if ($currentStock < $qty) {
                    throw new Exception("Stok barang {$item->name} tidak mencukupi di gudang (Sisa: {$currentStock}, Diminta: {$qty}).");
                }

                $stockBefore = $currentStock;
                $stockRecord->decrement('stock', $qty);
                $stockAfter = $stockRecord->fresh()->stock;

                $dispatch->items()->create([
                    'warehouse_item_id' => $item->id,
                    'quantity' => $qty,
                    'batch_number' => $batch,
                    'notes' => $itemData['notes'] ?? null,
                ]);

                // Log Movement
                WarehouseStockMovement::create([
                    'warehouse_id' => $data['source_warehouse_id'],
                    'warehouse_item_id' => $item->id,
                    'movement_date' => now(),
                    'movement_type' => 'Keluar',
                    'reference_number' => $dispatchNumber,
                    'quantity' => $qty,
                    'stock_before' => $stockBefore,
                    'stock_after' => $stockAfter,
                    'notes' => "Pengeluaran ke {$data['destination_name']} ({$dispatchNumber})",
                    'user_id' => Auth::id(),
                ]);

                // Jika tujuan Farmasi dan item terhubung dengan Medicine, tambahkan stok farmasi
                if ($data['destination_type'] === 'Farmasi' && $item->medicine_id) {
                    $med = Medicine::find($item->medicine_id);
                    if ($med) {
                        $medStock = MedicineStock::firstOrNew(['medicine_id' => $med->id, 'batch_number' => $batch]);
                        $medStock->stock = ($medStock->stock ?? 0) + $qty;
                        $medStock->save();
                    }
                }
            }

            ActivityLog::create([
                'user_id' => Auth::id(),
                'module' => 'Gudang',
                'action' => 'Pengeluaran Barang',
                'description' => "Pengeluaran barang {$dispatchNumber} ke unit {$data['destination_name']}",
            ]);

            return $dispatch;
        });
    }

    /**
     * Memproses Mutasi Barang Antar Gudang/Depo.
     */
    public function createMutation(array $data): WarehouseMutation
    {
        return DB::transaction(function () use ($data) {
            $mutationCount = WarehouseMutation::whereYear('created_at', now()->year)->count() + 1;
            $mutationNumber = 'MUT-'.now()->format('Ymd').'-'.str_pad($mutationCount, 4, '0', STR_PAD_LEFT);

            $mutation = WarehouseMutation::create([
                'mutation_number' => $mutationNumber,
                'mutation_date' => $data['mutation_date'],
                'source_warehouse_id' => $data['source_warehouse_id'],
                'target_warehouse_id' => $data['target_warehouse_id'],
                'status' => 'Selesai',
                'notes' => $data['notes'] ?? null,
                'created_by' => Auth::id(),
            ]);

            $sourceWarehouse = Warehouse::find($data['source_warehouse_id']);
            $targetWarehouse = Warehouse::find($data['target_warehouse_id']);

            foreach ($data['items'] as $itemData) {
                $item = WarehouseItem::findOrFail($itemData['warehouse_item_id']);
                $qty = (int) $itemData['quantity'];
                $batch = $itemData['batch_number'] ?? 'DEFAULT';

                // Potong stok gudang asal
                $sourceStock = WarehouseStock::where('warehouse_id', $data['source_warehouse_id'])
                    ->where('warehouse_item_id', $item->id)
                    ->first();

                if (! $sourceStock || $sourceStock->stock < $qty) {
                    throw new Exception("Stok barang {$item->name} tidak cukup di {$sourceWarehouse->name}.");
                }

                $sourceStockBefore = $sourceStock->stock;
                $sourceStock->decrement('stock', $qty);

                // Tambah stok gudang tujuan
                $targetStock = WarehouseStock::firstOrNew([
                    'warehouse_id' => $data['target_warehouse_id'],
                    'warehouse_item_id' => $item->id,
                    'batch_number' => $batch,
                ]);
                $targetStockBefore = (int) $targetStock->stock;
                $targetStock->stock = $targetStockBefore + $qty;
                $targetStock->save();

                $mutation->items()->create([
                    'warehouse_item_id' => $item->id,
                    'quantity' => $qty,
                    'batch_number' => $batch,
                ]);

                // Movement asal (Mutasi Keluar)
                WarehouseStockMovement::create([
                    'warehouse_id' => $data['source_warehouse_id'],
                    'warehouse_item_id' => $item->id,
                    'movement_date' => now(),
                    'movement_type' => 'Mutasi Keluar',
                    'reference_number' => $mutationNumber,
                    'quantity' => $qty,
                    'stock_before' => $sourceStockBefore,
                    'stock_after' => $sourceStockBefore - $qty,
                    'notes' => "Mutasi ke {$targetWarehouse->name}",
                    'user_id' => Auth::id(),
                ]);

                // Movement tujuan (Mutasi Masuk)
                WarehouseStockMovement::create([
                    'warehouse_id' => $data['target_warehouse_id'],
                    'warehouse_item_id' => $item->id,
                    'movement_date' => now(),
                    'movement_type' => 'Mutasi Masuk',
                    'reference_number' => $mutationNumber,
                    'quantity' => $qty,
                    'stock_before' => $targetStockBefore,
                    'stock_after' => $targetStockBefore + $qty,
                    'notes' => "Mutasi dari {$sourceWarehouse->name}",
                    'user_id' => Auth::id(),
                ]);
            }

            ActivityLog::create([
                'user_id' => Auth::id(),
                'module' => 'Gudang',
                'action' => 'Mutasi Barang',
                'description' => "Mutasi barang {$mutationNumber} dari {$sourceWarehouse->name} ke {$targetWarehouse->name}",
            ]);

            return $mutation;
        });
    }

    /**
     * Memproses Stock Opname & Penyesuaian Stok.
     */
    public function createOpname(array $data): StockOpname
    {
        return DB::transaction(function () use ($data) {
            $opnameCount = StockOpname::whereYear('created_at', now()->year)->count() + 1;
            $opnameNumber = 'SOP-'.now()->format('Ymd').'-'.str_pad($opnameCount, 4, '0', STR_PAD_LEFT);

            $opname = StockOpname::create([
                'opname_number' => $opnameNumber,
                'opname_date' => $data['opname_date'],
                'warehouse_id' => $data['warehouse_id'],
                'status' => 'Selesai',
                'notes' => $data['notes'] ?? null,
                'created_by' => Auth::id(),
            ]);

            foreach ($data['items'] as $itemData) {
                $item = WarehouseItem::findOrFail($itemData['warehouse_item_id']);
                $physicalStock = (int) $itemData['physical_stock'];

                $stockRecord = WarehouseStock::where('warehouse_id', $data['warehouse_id'])
                    ->where('warehouse_item_id', $item->id)
                    ->first();

                $systemStock = $stockRecord ? (int) $stockRecord->stock : 0;
                $difference = $physicalStock - $systemStock;

                $opname->items()->create([
                    'warehouse_item_id' => $item->id,
                    'system_stock' => $systemStock,
                    'physical_stock' => $physicalStock,
                    'difference' => $difference,
                    'notes' => $itemData['notes'] ?? null,
                ]);

                // Adjust WarehouseStock
                if (! $stockRecord) {
                    $stockRecord = WarehouseStock::create([
                        'warehouse_id' => $data['warehouse_id'],
                        'warehouse_item_id' => $item->id,
                        'batch_number' => 'OPNAME-'.now()->format('Ym'),
                        'stock' => $physicalStock,
                    ]);
                } else {
                    $stockRecord->update(['stock' => $physicalStock]);
                }

                // Log Movement Adjustment
                WarehouseStockMovement::create([
                    'warehouse_id' => $data['warehouse_id'],
                    'warehouse_item_id' => $item->id,
                    'movement_date' => now(),
                    'movement_type' => 'Penyesuaian',
                    'reference_number' => $opnameNumber,
                    'quantity' => abs($difference),
                    'stock_before' => $systemStock,
                    'stock_after' => $physicalStock,
                    'notes' => "Stock Opname {$opnameNumber} (Selisih: {$difference})",
                    'user_id' => Auth::id(),
                ]);
            }

            ActivityLog::create([
                'user_id' => Auth::id(),
                'module' => 'Gudang',
                'action' => 'Stock Opname',
                'description' => "Penyesuaian stock opname {$opnameNumber}",
            ]);

            return $opname;
        });
    }
}
