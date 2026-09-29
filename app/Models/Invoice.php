<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Model Invoice untuk konsolidasi tagihan medis pasien.
 *
 * @property int $id
 * @property string $invoice_number
 * @property int $registration_id
 * @property int $patient_id
 * @property string $invoice_date
 * @property float $services_total
 * @property float $medicines_total
 * @property float $laboratory_total
 * @property float $room_total
 * @property float $subtotal
 * @property float $discount
 * @property float $grand_total
 * @property string $status
 */
class Invoice extends Model
{
    use HasFactory;

    public const STATUS_UNPAID = 'Belum Lunas';

    public const STATUS_PAID = 'Lunas';

    public const STATUS_CANCELLED = 'Batal';

    protected $fillable = [
        'invoice_number',
        'registration_id',
        'patient_id',
        'invoice_date',
        'services_total',
        'medicines_total',
        'laboratory_total',
        'room_total',
        'subtotal',
        'discount',
        'grand_total',
        'status',
        'notes',
        'created_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'invoice_date' => 'datetime',
            'services_total' => 'decimal:2',
            'medicines_total' => 'decimal:2',
            'laboratory_total' => 'decimal:2',
            'room_total' => 'decimal:2',
            'subtotal' => 'decimal:2',
            'discount' => 'decimal:2',
            'grand_total' => 'decimal:2',
        ];
    }

    public function scopeUnpaid(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_UNPAID);
    }

    public function scopePaid(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_PAID);
    }

    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class, 'registration_id');
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(InvoiceItem::class, 'invoice_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'invoice_id');
    }
}
