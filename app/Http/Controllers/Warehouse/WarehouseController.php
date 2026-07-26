<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use App\Models\Warehouse;
use App\Models\WarehouseItem;
use App\Models\WarehouseStockMovement;
use App\Services\WarehouseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\View\View;

class WarehouseController extends Controller
{
    public function __construct(
        protected WarehouseService $warehouseService
    ) {}

    /**
     * Dashboard Utama Manajemen Gudang.
     */
    public function index(): View
    {
        $data = $this->warehouseService->getDashboardMetrics();

        return view('modules.warehouse.index', $data);
    }

    /**
     * Halaman Kartu Stok (Stock Ledger).
     */
    public function stockCard(Request $request): View
    {
        $warehouses = Warehouse::where('is_active', true)->get();
        $items = WarehouseItem::where('is_active', true)->get();

        $query = WarehouseStockMovement::with(['warehouse', 'item', 'user']);

        if ($request->filled('warehouse_id')) {
            $query->where('warehouse_id', $request->warehouse_id);
        }

        if ($request->filled('warehouse_item_id')) {
            $query->where('warehouse_item_id', $request->warehouse_item_id);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('movement_date', [$request->start_date.' 00:00:00', $request->end_date.' 23:59:59']);
        }

        $movements = $query->latest('movement_date')->paginate(20)->withQueryString();

        return view('modules.warehouse.stock-card', compact('movements', 'warehouses', 'items'));
    }

    /**
     * Halaman Laporan Gudang.
     */
    public function reports(Request $request): View
    {
        $warehouses = Warehouse::where('is_active', true)->get();

        $query = WarehouseItem::with(['supplier', 'stocks.warehouse']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('code', 'like', "%{$search}%");
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $items = $query->paginate(20)->withQueryString();

        return view('modules.warehouse.reports', compact('items', 'warehouses'));
    }

    /**
     * Ekspor Laporan Gudang CSV Server-Side.
     */
    public function exportCsv(Request $request)
    {
        $filename = 'laporan_gudang_'.date('Ymd_His').'.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF)); // UTF-8 BOM

            fputcsv($file, ['SIMRS Kencana Medika - Laporan Persediaan Gudang']);
            fputcsv($file, ['Tanggal Cetak: '.date('d/m/Y H:i')]);
            fputcsv($file, []);
            fputcsv($file, ['Kode Barang', 'Barcode', 'Nama Barang', 'Kategori', 'Satuan', 'Min Stock', 'Max Stock', 'Total Stock', 'Harga Beli (Rp)', 'Nilai Total (Rp)']);

            $items = WarehouseItem::with('stocks')->latest()->get();
            foreach ($items as $item) {
                $totalStock = $item->total_stock;
                $totalValue = $totalStock * $item->purchase_price;

                fputcsv($file, [
                    $item->code,
                    $item->barcode ?? '-',
                    $item->name,
                    $item->category,
                    $item->unit,
                    $item->min_stock,
                    $item->max_stock,
                    $totalStock,
                    $item->purchase_price,
                    $totalValue,
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}
