<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model Diagnosis untuk mencatat ICD-10 diagnosa medis pasien.
 *
 * @property int $id
 * @property int $medical_record_id
 * @property string $icd10_code
 * @property string $icd10_name
 * @property string $type
 */
class Diagnosis extends Model
{
    use HasFactory;

    public const TYPE_PRIMARY = 'Utama';

    public const TYPE_SECONDARY = 'Sekunder';

    protected $fillable = [
        'medical_record_id',
        'icd10_code',
        'icd10_name',
        'type',
        'description',
        'created_by',
    ];

    public function medicalRecord(): BelongsTo
    {
        return $this->belongsTo(MedicalRecord::class, 'medical_record_id');
    }
}
