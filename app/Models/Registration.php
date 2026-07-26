<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Model Registration untuk pendaftaran kunjungan medis pasien (Rawat Jalan/Inap/IGD).
 *
 * @property int $id
 * @property string $registration_number
 * @property int $patient_id
 * @property string $service_type
 * @property string $registration_date
 * @property string $guarantor
 * @property string $status
 */
class Registration extends Model
{
    use HasFactory;

    public const TYPE_OUTPATIENT = 'Rawat Jalan';

    public const TYPE_INPATIENT = 'Rawat Inap';

    public const TYPE_EMERGENCY = 'IGD';

    public const STATUS_WAITING = 'Menunggu';

    public const STATUS_PROCESSING = 'Diproses';

    public const STATUS_COMPLETED = 'Selesai';

    public const STATUS_CANCELLED = 'Batal';

    protected $fillable = [
        'registration_number',
        'patient_id',
        'service_type',
        'registration_date',
        'guarantor',
        'status',
        'notes',
        'created_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'registration_date' => 'datetime',
        ];
    }

    public function scopeToday(Builder $query): Builder
    {
        return $query->whereDate('registration_date', now()->today());
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_WAITING);
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function queue(): HasOne
    {
        return $this->hasOne(Queue::class, 'registration_id');
    }

    public function outpatientVisit(): HasOne
    {
        return $this->hasOne(OutpatientVisit::class, 'registration_id');
    }

    public function inpatientVisit(): HasOne
    {
        return $this->hasOne(InpatientVisit::class, 'registration_id');
    }

    public function medicalRecords(): HasMany
    {
        return $this->hasMany(MedicalRecord::class, 'registration_id');
    }

    public function prescriptions(): HasMany
    {
        return $this->hasMany(Prescription::class, 'registration_id');
    }

    public function laboratoryOrders(): HasMany
    {
        return $this->hasMany(LaboratoryOrder::class, 'registration_id');
    }

    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class, 'registration_id');
    }
}
