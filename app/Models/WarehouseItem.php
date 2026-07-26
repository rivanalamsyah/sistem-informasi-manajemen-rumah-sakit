<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class WarehouseItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'barcode',
        'name',
        'category',
        'supplier_id',
        'medicine_id',
        'unit',
        'min_stock',
        'max_stock',
        'purchase_price',
        'sell_price',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'purchase_price' => 'decimal:2',
            'sell_price' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function medicine(): BelongsTo
    {
        return $this->belongsTo(Medicine::class);
    }

    public function stocks(): HasMany
    {
        return $this->hasMany(WarehouseStock::class);
    }

    public function movements(): HasMany
    {
        return $this->hasMany(WarehouseStockMovement::class);
    }

    public function getTotalStockAttribute(): int
    {
        return (int) $this->stocks()->sum('stock');
    }
}
