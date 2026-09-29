<?php

namespace App\Policies;

use App\Models\MedicalRecord;
use App\Models\User;

class MedicalRecordPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('manage-medical-records') || $user->hasAnyRole(['Dokter', 'Perawat']);
    }

    public function view(User $user, MedicalRecord $record): bool
    {
        return $user->hasPermission('manage-medical-records') || $user->hasAnyRole(['Dokter', 'Perawat']);
    }

    public function create(User $user): bool
    {
        return $user->hasPermission('manage-medical-records') || $user->hasRole('Dokter');
    }

    public function update(User $user, MedicalRecord $record): bool
    {
        return $user->hasPermission('manage-medical-records') || $user->hasRole('Dokter');
    }

    public function delete(User $user, MedicalRecord $record): bool
    {
        return $user->hasPermission('manage-medical-records');
    }
}
