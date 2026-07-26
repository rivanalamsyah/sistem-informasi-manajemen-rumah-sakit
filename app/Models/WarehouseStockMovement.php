<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WarehouseStockMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'warehouse_id',
        'warehouse_item_id',
        'movement_date',
        'movement_type',
        'reference_number',
        'quantity',
        'stock_before',
        'stock_after',
        'notes',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'movement_date' => 'datetime',
        ];
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(WarehouseItem::class, 'warehouse_item_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
