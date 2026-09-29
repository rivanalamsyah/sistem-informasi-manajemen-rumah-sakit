<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Model User untuk mengelola data akun pegawai, staf, & tenaga medis.
 *
 * @property int $id
 * @property string $name
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string|null $nik
 * @property string|null $phone
 * @property bool $is_active
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'nik',
        'phone',
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Scope untuk menyaring pengguna aktif.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Relasi ke Role pengguna.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    /**
     * Memeriksa apakah user memiliki role tertentu.
     */
    public function hasRole(string $role): bool
    {
        return $this->roles->contains('name', $role);
    }

    /**
     * Memeriksa apakah user memiliki salah satu dari beberapa role.
     */
    public function hasAnyRole(array|string $roles): bool
    {
        $roleArray = is_array($roles) ? $roles : explode(',', $roles);
        $roleArray = array_map('trim', $roleArray);

        return $this->roles->contains(fn ($r) => in_array($r->name, $roleArray));
    }

    /**
     * Relasi ke profil Dokter jika akun ini milik seorang Dokter.
     */
    public function doctor(): HasOne
    {
        return $this->hasOne(Doctor::class, 'user_id');
    }

    /**
     * Relasi ke Pendaftaran yang dibuat oleh user ini.
     */
    public function createdRegistrations(): HasMany
    {
        return $this->hasMany(Registration::class, 'created_by');
    }

    /**
     * Relasi ke Pembayaran yang diproses user ini sebagai Kasir.
     */
    public function processedPayments(): HasMany
    {
        return $this->hasMany(Payment::class, 'cashier_user_id');
    }

    /**
     * Relasi user pembuat akun.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relasi user pengubah akun.
     */
    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
