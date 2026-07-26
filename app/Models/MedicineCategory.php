<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Model MedicineCategory untuk mengelompokkan kategori obat dan alkes.
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 */
class MedicineCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
    ];

    public function medicines(): HasMany
    {
        return $this->hasMany(Medicine::class, 'category_id');
    }
}
