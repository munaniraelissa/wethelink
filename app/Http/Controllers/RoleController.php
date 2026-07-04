<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        abort_if(!auth()->user()->can('role-list'), 403);
        $roles = Role::with('permissions')
            ->orderByRaw("CASE WHEN name = 'Super Admin' THEN 0 ELSE 1 END")
            ->orderBy('name', 'ASC')
            ->paginate(10);
        return view('dashboard.roles.index', compact('roles'));
    }

    public function create()
    {
        abort_if(!auth()->user()->can('role-create'), 403);
        $permissions = Permission::all()->groupBy('module');
        return view('dashboard.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        abort_if(!auth()->user()->can('role-create'), 403);
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'required|array|min:1',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $roleName = trim($request->input('name'));
        $roleData = ['name' => $roleName];
        if (Schema::hasColumn('roles', 'is_protected')) {
            $roleData['is_protected'] = $roleName === 'Super Admin';
        }
        $role = Role::create($roleData);
        
        // Convert permission IDs to names
        $permissionNames = Permission::whereIn('id', $request->input('permissions'))
            ->pluck('name')
            ->toArray();
        
        $role->syncPermissions($permissionNames);

        return redirect()->route('roles.index')
            ->with('success', __('dashboard.role.created_successfully'));
    }
    public function show($id)
    {
        abort_if(!auth()->user()->can('role-list'), 403);
        $role = Role::with('permissions')->findOrFail($id);
        $permissions = Permission::all()->groupBy('module');
        $rolePermissionIds = $role->permissions->pluck('id')->toArray();
        return view('dashboard.roles.show', compact('role', 'permissions', 'rolePermissionIds'));
    }

    public function edit($id)
    {
        abort_if(!auth()->user()->can('role-edit'), 403);
        $role = Role::with('permissions')->findOrFail($id);
        
        if ($role->is_protected) {
            return redirect()->route('roles.index')
                ->with('warning', __('dashboard.role.cannot_edit_protected'));
        }

        $permissions = Permission::all()->groupBy('module');
        $rolePermissionIds = $role->permissions->pluck('id')->toArray();

        return view('dashboard.roles.edit', compact('role', 'permissions', 'rolePermissionIds'));
    }

    public function update(Request $request, $id)
    {
        abort_if(!auth()->user()->can('role-edit'), 403);
        $role = Role::findOrFail($id);

        if ($role->is_protected) {
            return redirect()->route('roles.index')
                ->with('warning', __('dashboard.role.cannot_edit_protected'));
        }

        $request->validate([
            'name' => 'required|unique:roles,name,' . $id,
            'permissions' => 'required|array|min:1',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role->update(['name' => $request->input('name')]);
        
        // Convert permission IDs to names
        $permissionNames = Permission::whereIn('id', $request->input('permissions'))
            ->pluck('name')
            ->toArray();
        
        $role->syncPermissions($permissionNames);

        return redirect()->route('roles.index')
            ->with('success', __('dashboard.role.updated_successfully'));
    }

    public function destroy($id)
    {
        abort_if(!auth()->user()->can('role-delete'), 403);
        $role = Role::findOrFail($id);

        if ($this->isProtectedRole($role) || in_array($role->name, ['Admin', 'Normal Member'], true)) {
            return redirect()->route('roles.index')
                ->with('error', __('dashboard.role.cannot_delete_protected'));
        }

        $role->delete();

        return redirect()->route('roles.index')
            ->with('success', __('dashboard.role.deleted_successfully'));
    }

    private function isProtectedRole(Role $role): bool
    {
        return (bool) $role->is_protected || $role->name === 'Super Admin';
    }
}
