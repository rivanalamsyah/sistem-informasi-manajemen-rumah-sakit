<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Model MedicineStock untuk mengelola jumlah fisik stok obat per batch & kadaluarsa.
 *
 * @property int $id
 * @property int $medicine_id
 * @property string $location
 * @property string $batch_number
 * @property string $expired_date
 * @property int $stock
 */
class MedicineStock extends Model
{
    use HasFactory;

    public const LOCATION_GUDANG = 'Gudang';

    public const LOCATION_DEPO = 'Depo Farmasi';

    protected $fillable = [
        'medicine_id',
        'location',
        'batch_number',
        'expired_date',
        'stock',
        'created_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'expired_date' => 'date',
            'stock' => 'integer',
        ];
    }

    public function scopeByLocation(Builder $query, string $location): Builder
    {
        return $query->where('location', $location);
    }

    public function medicine(): BelongsTo
    {
        return $this->belongsTo(Medicine::class, 'medicine_id');
    }

    public function movements(): HasMany
    {
        return $this->hasMany(MedicineStockMovement::class, 'medicine_stock_id');
    }
}
