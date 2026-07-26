<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Model Bed untuk mengelola tempat tidur dan ketersediaan kamar rawat inap.
 *
 * @property int $id
 * @property int $room_id
 * @property string $bed_number
 * @property string $class
 * @property string $status
 * @property float $price_per_night
 */
class Bed extends Model
{
    use HasFactory, SoftDeletes;

    public const STATUS_EMPTY = 'Kosong';

    public const STATUS_OCCUPIED = 'Terisi';

    public const STATUS_CLEANING = 'Dibersihkan';

    public const STATUS_MAINTENANCE = 'Pemeliharaan';

    protected $fillable = [
        'room_id',
        'bed_number',
        'class',
        'status',
        'price_per_night',
    ];

    protected function casts(): array
    {
        return [
            'price_per_night' => 'decimal:2',
        ];
    }

    /**
     * Scope untuk menyaring bed yang siap digunakan (kosong).
     */
    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_EMPTY);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function inpatientVisits(): HasMany
    {
        return $this->hasMany(InpatientVisit::class, 'bed_id');
    }
}
