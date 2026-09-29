<?php

namespace App\Providers;

use App\Models\MedicalRecord;
use App\Models\Registration;
use App\Models\User;
use App\Policies\MedicalRecordPolicy;
use App\Policies\RegistrationPolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Daftarkan semua Policy secara eksplisit
        Gate::policy(Registration::class, RegistrationPolicy::class);
        Gate::policy(MedicalRecord::class, MedicalRecordPolicy::class);
        Gate::policy(User::class, UserPolicy::class);

        // Super Admin selalu diperbolehkan melewati semua gate checks
        Gate::before(function (User $user, string $ability) {
            if ($user->hasRole('Super Admin')) {
                return true;
            }
        });

        // Dynamic Gate resolution berbasis Permission database
        Gate::after(function (User $user, string $ability, ?bool $result) {
            if ($result === null) {
                return $user->hasPermission($ability);
            }

            return $result;
        });
    }
}
