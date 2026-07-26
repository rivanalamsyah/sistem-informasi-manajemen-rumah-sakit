<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model Queue untuk antrean pemanggilan pasien di Poliklinik.
 *
 * @property int $id
 * @property int $registration_id
 * @property int $department_id
 * @property int $doctor_id
 * @property int $queue_number
 * @property string $queue_code
 * @property string $queue_date
 * @property string $status
 */
class Queue extends Model
{
    use HasFactory;

    public const STATUS_WAITING = 'Menunggu';

    public const STATUS_CALLED = 'Dipanggil';

    public const STATUS_EXAMINING = 'Sedang Diperiksa';

    public const STATUS_COMPLETED = 'Selesai';

    public const STATUS_CANCELLED = 'Batal';

    protected $fillable = [
        'registration_id',
        'department_id',
        'doctor_id',
        'queue_number',
        'queue_code',
        'queue_date',
        'status',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'queue_date' => 'date',
            'queue_number' => 'integer',
        ];
    }

    public function scopeToday(Builder $query): Builder
    {
        return $query->whereDate('queue_date', now()->today());
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->whereIn('status', [self::STATUS_WAITING, self::STATUS_CALLED]);
    }

    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class, 'registration_id');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }
}
