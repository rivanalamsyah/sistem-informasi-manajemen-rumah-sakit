<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct(
        protected DashboardService $dashboardService
    ) {}

    /**
     * Menampilkan halaman Dashboard utama SIMRS yang disesuaikan dengan role & izin pengguna.
     */
    public function index(): View
    {
        $user = Auth::user();
        $data = $this->dashboardService->getDashboardData($user);

        return view('modules.dashboard.index', $data);
    }
}
