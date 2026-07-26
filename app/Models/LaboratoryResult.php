<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model LaboratoryResult untuk mencatat nilai dan kesimpulan hasil pengujian sampel lab.
 *
 * @property int $id
 * @property int $laboratory_order_id
 * @property int $laboratory_test_id
 * @property string|null $result_value
 * @property bool $is_abnormal
 * @property string $result_date
 */
class LaboratoryResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'laboratory_order_id',
        'laboratory_test_id',
        'result_value',
        'reference_range',
        'unit',
        'is_abnormal',
        'notes',
        'analyst_user_id',
        'doctor_in_charge_id',
        'result_date',
    ];

    protected function casts(): array
    {
        return [
            'is_abnormal' => 'boolean',
            'result_date' => 'datetime',
        ];
    }

    public function scopeAbnormal(Builder $query): Builder
    {
        return $query->where('is_abnormal', true);
    }

    public function laboratoryOrder(): BelongsTo
    {
        return $this->belongsTo(LaboratoryOrder::class, 'laboratory_order_id');
    }

    public function laboratoryTest(): BelongsTo
    {
        return $this->belongsTo(LaboratoryTest::class, 'laboratory_test_id');
    }

    public function analyst(): BelongsTo
    {
        return $this->belongsTo(User::class, 'analyst_user_id');
    }

    public function doctorInCharge(): BelongsTo
    {
        return $this->belongsTo(Doctor::class, 'doctor_in_charge_id');
    }
}
