<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Model Department untuk mengelola data unit Poliklinik rawat jalan.
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string|null $description
 * @property bool $is_active
 */
class Department extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'description',
        'is_active',
        'created_by',
        'updated_by',
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
     * Relasi ke daftar dokter spesialis di poliklinik ini.
     */
    public function doctors(): HasMany
    {
        return $this->hasMany(Doctor::class, 'department_id');
    }

    /**
     * Relasi ke antrean pelayanan di poliklinik ini.
     */
    public function queues(): HasMany
    {
        return $this->hasMany(Queue::class, 'department_id');
    }

    /**
     * Relasi ke kunjungan rawat jalan di poliklinik ini.
     */
    public function outpatientVisits(): HasMany
    {
        return $this->hasMany(OutpatientVisit::class, 'department_id');
    }

    /**
     * Relasi ke daftar tindakan medis khusus poliklinik ini.
     */
    public function services(): HasMany
    {
        return $this->hasMany(Service::class, 'department_id');
    }
}
