<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model MedicineStockMovement untuk mencatat kartu stok mutasi masuk/keluar.
 *
 * @property int $id
 * @property int $medicine_stock_id
 * @property string $type
 * @property int $quantity
 * @property string|null $reference_number
 */
class MedicineStockMovement extends Model
{
    use HasFactory;

    public const TYPE_IN = 'Masuk';

    public const TYPE_OUT = 'Keluar';

    public const TYPE_MUTATION = 'Mutasi';

    public const TYPE_ADJUSTMENT = 'Penyesuaian';

    public const TYPE_RETURN = 'Retur';

    protected $fillable = [
        'medicine_stock_id',
        'type',
        'quantity',
        'reference_number',
        'notes',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
        ];
    }

    public function medicineStock(): BelongsTo
    {
        return $this->belongsTo(MedicineStock::class, 'medicine_stock_id');
    }
}
