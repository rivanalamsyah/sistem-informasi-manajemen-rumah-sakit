<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\UserLogin;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityLogController extends Controller
{
    /**
     * Halaman Audit Trail (Activity Logs).
     */
    public function auditTrail(Request $request): View
    {
        $query = ActivityLog::with('user');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                    ->orWhere('action', 'like', "%{$search}%")
                    ->orWhere('module', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('name', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('module')) {
            $query->where('module', $request->module);
        }

        $activities = $query->latest()->paginate(25)->withQueryString();

        return view('modules.user.activities.index', compact('activities'));
    }

    /**
     * Halaman Riwayat Login (Login History).
     */
    public function loginHistory(Request $request): View
    {
        $query = UserLogin::with('user');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('ip_address', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $logins = $query->latest('login_at')->paginate(25)->withQueryString();

        return view('modules.user.activities.logins', compact('logins'));
    }
}
