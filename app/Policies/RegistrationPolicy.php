<?php

namespace App\Policies;

use App\Models\Registration;
use App\Models\User;

class RegistrationPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['Super Admin', 'Admin', 'Petugas Pendaftaran', 'Kasir', 'Dokter', 'Perawat']);
    }

    public function view(User $user, Registration $registration): bool
    {
        return $user->hasAnyRole(['Super Admin', 'Admin', 'Petugas Pendaftaran', 'Kasir', 'Dokter', 'Perawat']);
    }

    public function create(User $user): bool
    {
        return $user->hasPermission('manage-registrations');
    }

    public function update(User $user, Registration $registration): bool
    {
        return $user->hasPermission('manage-registrations');
    }

    public function delete(User $user, Registration $registration): bool
    {
        return $user->hasPermission('manage-registrations');
    }
}
