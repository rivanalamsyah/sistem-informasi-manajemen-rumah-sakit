<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Model Room untuk mengelola data ruangan dan bangsal rawat inap.
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string $building
 * @property string $floor
 * @property string $room_type
 * @property bool $is_active
 */
class Room extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'building',
        'floor',
        'room_type',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Relasi ke seluruh bed tempat tidur di ruangan ini.
     */
    public function beds(): HasMany
    {
        return $this->hasMany(Bed::class, 'room_id');
    }
}
