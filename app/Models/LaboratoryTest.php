<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Model LaboratoryTest untuk mengelola katalog item pemeriksaan lab dan tarif.
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string $category
 * @property float $price
 * @property bool $is_active
 */
class LaboratoryTest extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'category',
        'unit',
        'reference_range_male',
        'reference_range_female',
        'price',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function laboratoryResults(): HasMany
    {
        return $this->hasMany(LaboratoryResult::class, 'laboratory_test_id');
    }
}
