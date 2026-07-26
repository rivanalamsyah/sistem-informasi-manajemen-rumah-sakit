<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function __construct(
        protected DashboardService $dashboardService
    ) {}

    /**
     * Menampilkan halaman Dashboard utama SIMRS.
     */
    public function index(): View
    {
        $data = $this->dashboardService->getDashboardData();

        return view('modules.dashboard.index', $data);
    }
}
