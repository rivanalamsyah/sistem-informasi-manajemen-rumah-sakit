<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model OutpatientVisit untuk mencatat riwayat pemeriksaan Rawat Jalan.
 *
 * @property int $id
 * @property int $registration_id
 * @property int $department_id
 * @property int $doctor_id
 * @property string $visit_date
 * @property array|null $vital_signs
 * @property string $status
 */
class OutpatientVisit extends Model
{
    use HasFactory;

    public const STATUS_EXAMINING = 'Diperiksa';

    public const STATUS_COMPLETED = 'Selesai';

    public const STATUS_CANCELLED = 'Batal';

    protected $fillable = [
        'registration_id',
        'department_id',
        'doctor_id',
        'visit_date',
        'complaint',
        'vital_signs',
        'status',
        'created_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'visit_date' => 'datetime',
            'vital_signs' => 'array',
        ];
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
