<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WarehouseMutationItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'warehouse_mutation_id',
        'warehouse_item_id',
        'quantity',
        'batch_number',
    ];

    public function mutation(): BelongsTo
    {
        return $this->belongsTo(WarehouseMutation::class, 'warehouse_mutation_id');
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(WarehouseItem::class, 'warehouse_item_id');
    }
}
