<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WarehouseReceipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'receipt_number',
        'receipt_date',
        'warehouse_id',
        'supplier_id',
        'invoice_number',
        'total_amount',
        'notes',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'receipt_date' => 'date',
            'total_amount' => 'decimal:2',
        ];
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function items(): HasMany
    {
        return $this->hasMany(WarehouseReceiptItem::class);
    }
}
