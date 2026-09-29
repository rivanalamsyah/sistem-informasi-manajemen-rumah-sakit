<?php

namespace App\Providers;

use App\Models\User;
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
