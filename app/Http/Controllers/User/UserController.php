<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\ActivityLog;
use App\Models\Role;
use App\Models\User;
use App\Models\UserLogin;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class UserController extends Controller
{
    public function __construct(
        protected UserService $userService
    ) {}

    /**
     * Dashboard & Manajemen Daftar User.
     */
    public function index(Request $request): View
    {
        $metricsData = $this->userService->getDashboardMetrics();

        $query = User::with('roles');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $roleName = $request->role;
            $query->whereHas('roles', function ($q) use ($roleName) {
                $q->where('name', $roleName);
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $users = $query->latest()->paginate(15)->withQueryString();
        $roles = Role::all();

        return view('modules.user.index', array_merge($metricsData, compact('users', 'roles')));
    }

    public function create(): View
    {
        $roles = Role::all();

        return view('modules.user.create', compact('roles'));
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $user = User::create([
            'name'      => $validated['name'],
            'username'  => $validated['username'],
            'email'     => $validated['email'],
            'password'  => Hash::make($validated['password']),
            'nik'       => $validated['nik'] ?? null,
            'phone'     => $validated['phone'] ?? null,
            'is_active' => $request->boolean('is_active', true),
            'created_by' => Auth::id(),
        ]);

        if (! empty($validated['roles'])) {
            $user->roles()->sync($validated['roles']);
        }

        ActivityLog::create([
            'user_id'     => Auth::id(),
            'module'      => 'Manajemen User',
            'action'      => 'Tambah User',
            'description' => "Membuat akun pengguna baru: {$user->name} ({$user->username})",
        ]);

        return redirect()->route('users.index')
            ->with('success', "User baru {$user->name} berhasil ditambahkan!");
    }

    public function show(User $user): View
    {
        $user->load(['roles.permissions', 'creator', 'doctor']);

        $loginHistory = UserLogin::where('user_id', $user->id)
            ->latest('login_at')
            ->take(10)
            ->get();

        $activityLogs = ActivityLog::where('user_id', $user->id)
            ->latest()
            ->take(10)
            ->get();

        return view('modules.user.show', compact('user', 'loginHistory', 'activityLogs'));
    }

    public function edit(User $user): View
    {
        $roles = Role::all();
        $userRoleIds = $user->roles->pluck('id')->toArray();

        return view('modules.user.edit', compact('user', 'roles', 'userRoleIds'));
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $validated = $request->validated();
        $oldValues = $user->only(['name', 'username', 'email', 'nik', 'phone', 'is_active']);

        $user->update([
            'name'       => $validated['name'],
            'username'   => $validated['username'],
            'email'      => $validated['email'],
            'nik'        => $validated['nik'] ?? null,
            'phone'      => $validated['phone'] ?? null,
            'is_active'  => $request->boolean('is_active'),
            'updated_by' => Auth::id(),
        ]);

        if (isset($validated['roles'])) {
            $user->roles()->sync($validated['roles']);
        }

        ActivityLog::create([
            'user_id'     => Auth::id(),
            'module'      => 'Manajemen User',
            'action'      => 'Edit User',
            'description' => "Memperbarui data akun pengguna {$user->name}",
            'old_values'  => $oldValues,
            'new_values'  => $user->fresh()->only(['name', 'username', 'email', 'nik', 'phone', 'is_active']),
        ]);

        return redirect()->route('users.index')
            ->with('success', "Data pengguna {$user->name} berhasil diperbarui!");
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri!');
        }

        $userName = $user->name;
        $user->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'module' => 'Manajemen User',
            'action' => 'Hapus User',
            'description' => "Menghapus akun pengguna {$userName}",
        ]);

        return redirect()->route('users.index')
            ->with('success', "Akun pengguna {$userName} berhasil dihapus.");
    }

    public function toggleActive(User $user): RedirectResponse
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menonaktifkan akun Anda sendiri!');
        }

        $user->update(['is_active' => ! $user->is_active]);
        $statusText = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';

        ActivityLog::create([
            'user_id' => Auth::id(),
            'module' => 'Manajemen User',
            'action' => 'Toggle Status',
            'description' => "Status akun {$user->name} diubah menjadi {$statusText}",
        ]);

        return back()->with('success', "Akun {$user->name} berhasil {$statusText}.");
    }

    public function resetPassword(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'new_password' => ['required', 'string', 'min:8'],
        ]);

        $user->update(['password' => Hash::make($request->new_password)]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'module' => 'Manajemen User',
            'action' => 'Reset Password',
            'description' => "Mereset kata sandi akun {$user->name}",
        ]);

        return back()->with('success', "Kata sandi pengguna {$user->name} berhasil direset!");
    }

    /**
     * Halaman Profil Diri Pengguna.
     */
    public function profile(): View
    {
        $user = Auth::user()->load('roles.permissions');

        $loginHistory = UserLogin::where('user_id', $user->id)
            ->latest('login_at')
            ->take(10)
            ->get();

        $activityLogs = ActivityLog::where('user_id', $user->id)
            ->latest()
            ->take(10)
            ->get();

        return view('modules.user.profile', compact('user', 'loginHistory', 'activityLogs'));
    }

    /**
     * Update Profil & Password Diri Sendiri.
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email,'.$user->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'current_password' => ['nullable', 'required_with:new_password'],
            'new_password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        if (! empty($validated['new_password'])) {
            if (! Hash::check($validated['current_password'], $user->password)) {
                return back()->withErrors(['current_password' => 'Kata sandi saat ini salah.']);
            }
            $user->password = Hash::make($validated['new_password']);
        }

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'] ?? null;
        $user->save();

        ActivityLog::create([
            'user_id' => $user->id,
            'module' => 'Profil',
            'action' => 'Update Profil',
            'description' => "Pengguna {$user->name} memperbarui profil dan data diri.",
        ]);

        return back()->with('success', 'Profil dan akun Anda berhasil diperbarui!');
    }
}
