<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Model Patient untuk mengelola identitas terpusat pasien rumah sakit.
 *
 * @property int $id
 * @property string $mr_number
 * @property string $nik
 * @property string $name
 * @property string $birth_place
 * @property string $birth_date
 * @property string $gender
 * @property string $blood_type
 * @property string|null $phone
 * @property string $address
 */
class Patient extends Model
{
    use HasFactory, SoftDeletes;

    public const GENDER_MALE = 'L';

    public const GENDER_FEMALE = 'P';

    protected $fillable = [
        'mr_number',
        'nik',
        'name',
        'birth_place',
        'birth_date',
        'gender',
        'blood_type',
        'religion',
        'marital_status',
        'occupation',
        'phone',
        'email',
        'address',
        'guardian_name',
        'guardian_phone',
        'guardian_relation',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
        ];
    }

    /**
     * Scope pencarian cepat berdasarkan Nama, No. RM, atau NIK.
     */
    public function scopeSearch(Builder $query, string $keyword): Builder
    {
        return $query->where('name', 'like', "%{$keyword}%")
            ->orWhere('mr_number', 'like', "%{$keyword}%")
            ->orWhere('nik', 'like', "%{$keyword}%");
    }

    /**
     * Relasi ke seluruh pendaftaran kunjungan pasien.
     */
    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class, 'patient_id');
    }

    /**
     * Relasi ke seluruh rekam medis pasien.
     */
    public function medicalRecords(): HasMany
    {
        return $this->hasMany(MedicalRecord::class, 'patient_id');
    }

    /**
     * Relasi ke seluruh resep obat pasien.
     */
    public function prescriptions(): HasMany
    {
        return $this->hasMany(Prescription::class, 'patient_id');
    }

    /**
     * Relasi ke seluruh order laboratorium pasien.
     */
    public function laboratoryOrders(): HasMany
    {
        return $this->hasMany(LaboratoryOrder::class, 'patient_id');
    }

    /**
     * Relasi ke seluruh invoice tagihan pasien.
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class, 'patient_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
