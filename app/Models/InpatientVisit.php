<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model InpatientVisit untuk mengelola data opname dan admisi Rawat Inap.
 *
 * @property int $id
 * @property int $registration_id
 * @property int $bed_id
 * @property int $doctor_id
 * @property string $admission_date
 * @property string|null $discharge_date
 * @property string $status
 */
class InpatientVisit extends Model
{
    use HasFactory;

    public const STATUS_ACTIVE = 'Aktif';

    public const STATUS_CHECKOUT_MEDICAL = 'Checkout Medis';

    public const STATUS_CHECKOUT_BILLING = 'Checkout Billing';

    public const STATUS_CANCELLED = 'Batal';

    protected $fillable = [
        'registration_id',
        'bed_id',
        'doctor_id',
        'admission_date',
        'discharge_date',
        'initial_diagnosis',
        'discharge_reason',
        'status',
        'created_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'admission_date' => 'datetime',
            'discharge_date' => 'datetime',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class, 'registration_id');
    }

    public function bed(): BelongsTo
    {
        return $this->belongsTo(Bed::class, 'bed_id');
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }
}
