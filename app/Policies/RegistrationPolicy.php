<?php

namespace App\Policies;

use App\Models\Registration;
use App\Models\User;

/**
 * RegistrationPolicy — Otorisasi resource-level untuk Pendaftaran Pasien.
 *
 * Mencegah:
 * - Perubahan registrasi yang sudah Selesai atau Batal (immutable)
 * - Akses dari role yang tidak berwenang
 * - Super Admin selalu melewati policy ini (Gate::before di AppServiceProvider)
 */
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

    /**
     * Update hanya boleh jika registrasi belum final (belum Selesai/Batal).
     */
    public function update(User $user, Registration $registration): bool
    {
        if (in_array($registration->status, [Registration::STATUS_COMPLETED, Registration::STATUS_CANCELLED])) {
            return false;
        }

        return $user->hasPermission('manage-registrations');
    }

    /**
     * Cancel hanya boleh jika registrasi belum final (belum Selesai/Batal).
     */
    public function cancel(User $user, Registration $registration): bool
    {
        if (in_array($registration->status, [Registration::STATUS_COMPLETED, Registration::STATUS_CANCELLED])) {
            return false;
        }

        return $user->hasAnyRole(['Super Admin', 'Admin', 'Petugas Pendaftaran']);
    }

    public function delete(User $user, Registration $registration): bool
    {
        return $user->hasAnyRole(['Super Admin', 'Admin']);
    }
}
