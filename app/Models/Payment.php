<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model Payment untuk pencatatan transaksi penerimaan kas dan kuitansi.
 *
 * @property int $id
 * @property string $receipt_number
 * @property int $invoice_id
 * @property string $payment_date
 * @property string $payment_method
 * @property float $amount_paid
 * @property float $change_amount
 * @property int $cashier_user_id
 */
class Payment extends Model
{
    use HasFactory;

    public const METHOD_CASH = 'Tunai';

    public const METHOD_TRANSFER = 'Transfer Bank';

    public const METHOD_DEBIT = 'Kartu Debit';

    public const METHOD_CREDIT = 'Kartu Kredit';

    protected $fillable = [
        'receipt_number',
        'invoice_id',
        'payment_date',
        'payment_method',
        'amount_paid',
        'change_amount',
        'cashier_user_id',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'payment_date' => 'datetime',
            'amount_paid' => 'decimal:2',
            'change_amount' => 'decimal:2',
        ];
    }

    public function scopeToday(Builder $query): Builder
    {
        return $query->whereDate('payment_date', now()->today());
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

    public function cashier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cashier_user_id');
    }
}
