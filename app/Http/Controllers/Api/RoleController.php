<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    // Get all roles with their permissions
    public function index()
    {
        $roles = Role::with('permissions')->get();
        return response()->json($roles);
    }

    // Create a new role
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name',
            'permissions' => 'nullable|array',
        ]);

        $role = Role::create(['name' => $request->name]);

        if ($request->permissions) {
            $role->givePermissionTo($request->permissions);
        }

        return response()->json($role->load('permissions'), 201);
    }

    // Show one role
    public function show(Role $role)
    {
        return response()->json($role->load('permissions'));
    }

    // Update role's permissions
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'permissions' => 'nullable|array',
        ]);

        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return response()->json($role->load('permissions'));
    }

    // Delete role
    public function destroy(Role $role)
    {
        $role->delete();
        return response()->json(['message' => 'Role deleted successfully']);
    }

    // Get all permissions (helper endpoint)
    public function allPermissions()
    {
        return response()->json(Permission::all());
    }
}