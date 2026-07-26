<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Model Permission untuk mengelola izin spesifik fitur SIMRS.
 *
 * @property int $id
 * @property string $name
 * @property string $guard_name
 * @property string|null $group
 */
class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'guard_name',
        'group',
    ];

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'permission_role');
    }
}
