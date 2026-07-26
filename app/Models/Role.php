<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Model Role untuk mengelola peran dan hak akses pengguna.
 *
 * @property int $id
 * @property string $name
 * @property string $guard_name
 * @property string|null $description
 */
class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'guard_name',
        'description',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'role_user');
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'permission_role');
    }
}
