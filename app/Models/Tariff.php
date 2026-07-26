<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Model Tariff untuk mengelola nominal harga tindakan medis per kelas pelayanan.
 *
 * @property int $id
 * @property int|null $service_id
 * @property string $class
 * @property float $amount
 * @property bool $is_active
 */
class Tariff extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'service_id',
        'class',
        'amount',
        'description',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeByClass(Builder $query, string $class): Builder
    {
        return $query->where('class', $class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}
