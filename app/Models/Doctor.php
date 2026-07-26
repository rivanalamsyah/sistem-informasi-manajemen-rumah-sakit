<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Model Doctor untuk mengelola profil medis dan spesialisasi dokter.
 *
 * @property int $id
 * @property int|null $user_id
 * @property int $department_id
 * @property string $sip
 * @property string $name
 * @property string|null $specialization
 * @property bool $is_active
 */
class Doctor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'department_id',
        'sip',
        'name',
        'title_prefix',
        'title_suffix',
        'specialization',
        'phone',
        'email',
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by',
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

    public function scopeByDepartment(Builder $query, int $departmentId): Builder
    {
        return $query->where('department_id', $departmentId);
    }

    /**
     * Accessor untuk nama lengkap beserta gelar.
     */
    public function getFullNameAttribute(): string
    {
        $prefix = $this->title_prefix ? $this->title_prefix.' ' : '';
        $suffix = $this->title_suffix ? ', '.$this->title_suffix : '';

        return $prefix.$this->name.$suffix;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function queues(): HasMany
    {
        return $this->hasMany(Queue::class, 'doctor_id');
    }

    public function outpatientVisits(): HasMany
    {
        return $this->hasMany(OutpatientVisit::class, 'doctor_id');
    }

    public function inpatientVisits(): HasMany
    {
        return $this->hasMany(InpatientVisit::class, 'doctor_id');
    }

    public function medicalRecords(): HasMany
    {
        return $this->hasMany(MedicalRecord::class, 'doctor_id');
    }

    public function prescriptions(): HasMany
    {
        return $this->hasMany(Prescription::class, 'doctor_id');
    }

    public function laboratoryOrders(): HasMany
    {
        return $this->hasMany(LaboratoryOrder::class, 'doctor_id');
    }
}
