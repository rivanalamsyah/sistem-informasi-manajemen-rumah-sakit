<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Model LaboratoryOrder untuk mengelola permintaan order tes laboratorium.
 *
 * @property int $id
 * @property string $order_number
 * @property int $registration_id
 * @property int $patient_id
 * @property int $doctor_id
 * @property string $order_date
 * @property string $status
 */
class LaboratoryOrder extends Model
{
    use HasFactory;

    public const STATUS_WAITING_SAMPLE = 'Menunggu Sampel';

    public const STATUS_PROCESSING = 'Diproses';

    public const STATUS_COMPLETED = 'Selesai';

    public const STATUS_CANCELLED = 'Batal';

    protected $fillable = [
        'order_number',
        'registration_id',
        'patient_id',
        'doctor_id',
        'order_date',
        'status',
        'clinical_notes',
        'created_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'order_date' => 'datetime',
        ];
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->whereIn('status', [self::STATUS_WAITING_SAMPLE, self::STATUS_PROCESSING]);
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

    public function results(): HasMany
    {
        return $this->hasMany(LaboratoryResult::class, 'laboratory_order_id');
    }
}
