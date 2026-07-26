<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model InvoiceItem untuk rincian komponen biaya pada invoice.
 *
 * @property int $id
 * @property int $invoice_id
 * @property string $item_type
 * @property string $item_name
 * @property int $quantity
 * @property float $unit_price
 * @property float $subtotal
 * @property int|null $reference_id
 */
class InvoiceItem extends Model
{
    use HasFactory;

    public const TYPE_SERVICE = 'Tindakan';

    public const TYPE_MEDICINE = 'Obat';

    public const TYPE_LAB = 'Laboratorium';

    public const TYPE_ROOM = 'Sewa_Kamar';

    public const TYPE_ADMIN = 'Administrasi';

    protected $fillable = [
        'invoice_id',
        'item_type',
        'item_name',
        'quantity',
        'unit_price',
        'subtotal',
        'reference_id',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'unit_price' => 'decimal:2',
            'subtotal' => 'decimal:2',
            'reference_id' => 'integer',
        ];
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }
}
