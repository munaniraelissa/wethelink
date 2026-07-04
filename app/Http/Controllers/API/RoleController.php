<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:role-create', ['only' => ['store']]);
        $this->middleware('permission:role-edit', ['only' => ['update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $roles = Role::with('permissions')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return response()->json($roles);
    }

    public function show(Role $role)
    {
        $role->load('permissions');

        return response()->json(['role' => $role]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permission' => 'required|array|min:1',
            'permission.*' => 'exists:permissions,id',
        ]);

        $roleData = ['name' => $request->input('name')];
        if (Schema::hasColumn('roles', 'is_protected')) {
            $roleData['is_protected'] = $request->input('name') === 'Super Admin';
        }
        $role = Role::create($roleData);
        $role->syncPermissions($request->input('permission'));
        $role->load('permissions');

        return response()->json([
            'message' => 'Role created successfully',
            'role' => $role,
        ], 201);
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required',
            'permission' => 'required|array|min:1',
            'permission.*' => 'exists:permissions,id',
        ]);

        if ($role->is_protected && $request->name !== $role->name) {
            return response()->json([
                'message' => 'You cannot rename a protected role.',
            ], 403);
        }

        if ($role->name === 'Admin') {
            $excludedForAdmin = ['delete users', 'delete roles', 'manage settings'];
            $filteredPermissions = array_diff($request->input('permission'), $excludedForAdmin);
            $role->syncPermissions($filteredPermissions);
            $role->load('permissions');

            return response()->json([
                'message' => 'Admin role updated (restricted permissions ignored).',
                'role' => $role,
            ]);
        }

        if ($role->name === 'Normal Member' && $role->is_protected) {
            $role->syncPermissions($request->input('permission'));
            $role->load('permissions');

            return response()->json([
                'message' => 'Permissions updated successfully for Normal Member.',
                'role' => $role,
            ]);
        }

        $role->name = $request->input('name');
        $role->save();
        $role->syncPermissions($request->input('permission'));
        $role->load('permissions');

        return response()->json([
            'message' => 'Role updated successfully.',
            'role' => $role,
        ]);
    }

    public function destroy(Role $role)
    {
        if ($role->is_protected || in_array($role->name, ['Admin', 'Normal Member'], true)) {
            return response()->json([
                'message' => 'You cannot delete a protected role.',
            ], 403);
        }

        $role->delete();

        return response()->json([
            'message' => 'Role deleted successfully.',
        ]);
    }
}
