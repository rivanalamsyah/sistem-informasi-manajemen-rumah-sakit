<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Model MedicalRecord untuk rekam medis SOAP (Subjective, Objective, Assessment, Plan).
 *
 * @property int $id
 * @property int $registration_id
 * @property int $patient_id
 * @property int $doctor_id
 * @property string $record_date
 * @property string|null $subjective
 * @property string|null $objective
 * @property string|null $assessment
 * @property string|null $plan
 */
class MedicalRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_id',
        'patient_id',
        'doctor_id',
        'record_date',
        'subjective',
        'objective',
        'assessment',
        'plan',
        'notes',
        'created_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'record_date' => 'datetime',
        ];
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

    public function diagnoses(): HasMany
    {
        return $this->hasMany(Diagnosis::class, 'medical_record_id');
    }
}
