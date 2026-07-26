<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Model Medicine untuk mengelola katalog data master obat dan alkes.
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string|null $generic_name
 * @property int $category_id
 * @property string $unit
 * @property string $type
 * @property int $min_stock
 * @property float $purchase_price
 * @property float $selling_price
 * @property bool $is_active
 */
class Medicine extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'generic_name',
        'category_id',
        'unit',
        'type',
        'min_stock',
        'purchase_price',
        'selling_price',
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected function casts(): array
    {
        return [
            'min_stock' => 'integer',
            'purchase_price' => 'decimal:2',
            'selling_price' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(MedicineCategory::class, 'category_id');
    }

    public function stocks(): HasMany
    {
        return $this->hasMany(MedicineStock::class, 'medicine_id');
    }

    public function prescriptionItems(): HasMany
    {
        return $this->hasMany(PrescriptionItem::class, 'medicine_id');
    }
}
