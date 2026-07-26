<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WarehouseReceiptItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'warehouse_receipt_id',
        'warehouse_item_id',
        'quantity',
        'purchase_price',
        'batch_number',
        'expired_date',
        'subtotal',
    ];

    protected function casts(): array
    {
        return [
            'expired_date' => 'date',
            'purchase_price' => 'decimal:2',
            'subtotal' => 'decimal:2',
        ];
    }

    public function receipt(): BelongsTo
    {
        return $this->belongsTo(WarehouseReceipt::class, 'warehouse_receipt_id');
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(WarehouseItem::class, 'warehouse_item_id');
    }
}
