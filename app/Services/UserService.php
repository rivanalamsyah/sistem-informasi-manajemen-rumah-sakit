<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\Role;
use App\Models\User;
use App\Models\UserLogin;
use Illuminate\Support\Facades\DB;

class UserService
{
    /**
     * Data statistik agregat untuk dashboard pengguna.
     */
    public function getDashboardMetrics(): array
    {
        $today = now()->toDateString();

        $totalUsers = User::count();
        $activeUsers = User::where('is_active', true)->count();
        $inactiveUsers = User::where('is_active', false)->count();
        $todayLoginsCount = UserLogin::whereDate('login_at', $today)->count();

        // User per Role
        $roleCounts = Role::withCount('users')->get();
        $roleLabels = $roleCounts->pluck('name')->toArray();
        $roleData = $roleCounts->pluck('users_count')->toArray();

        // Login Aktivitas Terbaru (10 Terakhir)
        $recentLogins = UserLogin::with('user')
            ->latest('login_at')
            ->take(10)
            ->get();

        // Audit Trail Activity Log Terbaru (10 Terakhir)
        $recentActivities = ActivityLog::with('user')
            ->latest()
            ->take(10)
            ->get();

        return [
            'metrics' => [
                'totalUsers' => $totalUsers,
                'activeUsers' => $activeUsers,
                'inactiveUsers' => $inactiveUsers,
                'todayLogins' => $todayLoginsCount,
            ],
            'roleDistribution' => [
                'labels' => $roleLabels,
                'data' => $roleData,
            ],
            'recentLogins' => $recentLogins,
            'recentActivities' => $recentActivities,
        ];
    }
}
