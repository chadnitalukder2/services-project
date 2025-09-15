<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RoleController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view roles', only: ['index']),
            new Middleware('permission:create roles', only: ['create', 'store']),
            new Middleware('permission:edit roles', only: ['edit', 'update']),
            new Middleware('permission:delete roles', only: ['destroy']),
        ];
    }
    public function index()
    {
        $roles = Role::with('permissions')->orderBy('created_at', 'desc')->paginate(12);
        $permissions = Permission::all();
        return view('backend.roles.list', compact('roles', 'permissions'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles|min:3',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $role = Role::create(['name' => $request->name]);

        if (!empty($request->permissions)) {
            foreach ($request->permissions as $name) {
                $role->givePermissionTo($name);
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Role created successfully',
            'role' => $role,
        ]);
    }


  public function update($id, Request $request)
{
    $role = Role::findOrFail($id);

    $validator = Validator::make($request->all(), [
        'name' => 'required|unique:roles,name,' . $id . ',id|min:3',
    ]);

    if ($validator->fails()) {
        // Return JSON response for validation errors
        return response()->json([
            'status' => false,
            'errors' => $validator->errors()
        ], 422);
    }

    // Update role name
    $role->name = $request->name;
    $role->save();

    // Sync permissions
    if (!empty($request->permissions)) {
        $role->syncPermissions($request->permissions);
    } else {
        $role->syncPermissions([]);
    }

    return response()->json([
        'status' => true,
        'message' => 'Role updated successfully!'
    ]);
}

    public function destroy(Request $request)
    {
        $id = $request->input('id');
        $role = Role::findOrFail($id);
        if ($role ===  null) {
            session()->flash('error', 'Role not found');
            return response()->json([
                'status' => false,
            ]);
        }
        $role->delete();
        session()->flash('success', 'Role deleted successfully');
        return response()->json([
            'status' => true,
        ]);
    }
}
