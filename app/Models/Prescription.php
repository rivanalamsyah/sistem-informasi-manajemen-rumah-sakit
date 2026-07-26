<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Model Prescription untuk mencatat E-Resep dokter.
 *
 * @property int $id
 * @property string $prescription_number
 * @property int $registration_id
 * @property int $patient_id
 * @property int $doctor_id
 * @property string $prescription_date
 * @property string $status
 */
class Prescription extends Model
{
    use HasFactory;

    public const STATUS_WAITING = 'Menunggu';

    public const STATUS_PROCESSING = 'Diproses';

    public const STATUS_COMPLETED = 'Selesai';

    public const STATUS_CANCELLED = 'Batal';

    protected $fillable = [
        'prescription_number',
        'registration_id',
        'patient_id',
        'doctor_id',
        'prescription_date',
        'status',
        'notes',
        'created_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'prescription_date' => 'datetime',
        ];
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_WAITING);
    }

    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class, 'registration_id');
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(PrescriptionItem::class, 'prescription_id');
    }
}
