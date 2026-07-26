<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RolePermissionController extends Controller
{
    /**
     * Halaman Kelola Roles & Matrix Permission.
     */
    public function indexRoles(): View
    {
        $roles = Role::with(['permissions', 'users'])->get();
        $permissions = Permission::all()->groupBy('group');

        return view('modules.user.roles.index', compact('roles', 'permissions'));
    }

    public function storeRole(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:50', 'unique:roles,name'],
            'description' => ['nullable', 'string', 'max:255'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['exists:permissions,id'],
        ]);

        $role = Role::create([
            'name' => $validated['name'],
            'guard_name' => 'web',
            'description' => $validated['description'] ?? null,
        ]);

        if (! empty($validated['permissions'])) {
            $role->permissions()->sync($validated['permissions']);
        }

        ActivityLog::create([
            'user_id' => Auth::id(),
            'module' => 'Hak Akses',
            'action' => 'Tambah Role',
            'description' => "Membuat peran / role baru: {$role->name}",
        ]);

        return back()->with('success', "Role '{$role->name}' berhasil ditambahkan!");
    }

    public function updateRole(Request $request, Role $role): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:50', 'unique:roles,name,'.$role->id],
            'description' => ['nullable', 'string', 'max:255'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['exists:permissions,id'],
        ]);

        $role->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
        ]);

        $role->permissions()->sync($validated['permissions'] ?? []);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'module' => 'Hak Akses',
            'action' => 'Update Role',
            'description' => "Memperbarui peran / role: {$role->name}",
        ]);

        return back()->with('success', "Peran '{$role->name}' & hak aksesnya berhasil diperbarui!");
    }

    public function destroyRole(Role $role): RedirectResponse
    {
        if ($role->name === 'Super Admin') {
            return back()->with('error', 'Role Super Admin tidak dapat dihapus!');
        }

        $roleName = $role->name;
        $role->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'module' => 'Hak Akses',
            'action' => 'Hapus Role',
            'description' => "Menghapus role: {$roleName}",
        ]);

        return back()->with('success', "Role '{$roleName}' berhasil dihapus.");
    }

    /**
     * Halaman Permission Matrix (Grid Matrix Hak Akses per Role).
     */
    public function matrix(): View
    {
        $roles = Role::with('permissions')->get();
        $groupedPermissions = Permission::all()->groupBy('group');

        return view('modules.user.roles.matrix', compact('roles', 'groupedPermissions'));
    }

    /**
     * Update Permission Matrix sekaligus.
     */
    public function updateMatrix(Request $request): RedirectResponse
    {
        $matrix = $request->input('matrix', []); // [role_id => [perm_id1, perm_id2]]

        foreach (Role::all() as $role) {
            $permIds = $matrix[$role->id] ?? [];
            $role->permissions()->sync($permIds);
        }

        ActivityLog::create([
            'user_id' => Auth::id(),
            'module' => 'Hak Akses',
            'action' => 'Update Matrix',
            'description' => 'Matriks hak akses / permission per role berhasil diperbarui.',
        ]);

        return back()->with('success', 'Permission Matrix berhasil diperbarui!');
    }
}
