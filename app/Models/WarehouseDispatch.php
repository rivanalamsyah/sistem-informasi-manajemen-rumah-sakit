<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WarehouseDispatch extends Model
{
    use HasFactory;

    protected $fillable = [
        'dispatch_number',
        'dispatch_date',
        'source_warehouse_id',
        'destination_type',
        'destination_name',
        'status',
        'notes',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'dispatch_date' => 'date',
        ];
    }

    public function sourceWarehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class, 'source_warehouse_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function items(): HasMany
    {
        return $this->hasMany(WarehouseDispatchItem::class);
    }
}
