<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WarehouseDispatchItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'warehouse_dispatch_id',
        'warehouse_item_id',
        'quantity',
        'batch_number',
        'notes',
    ];

    public function dispatch(): BelongsTo
    {
        return $this->belongsTo(WarehouseDispatch::class, 'warehouse_dispatch_id');
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(WarehouseItem::class, 'warehouse_item_id');
    }
}
