<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use function Pest\Laravel\json;

class PermissionController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view permissions', only: ['index', 'show']),
            // new Middleware('permission:create permissions', only: ['create', 'store']),
            // new Middleware('permission:edit permissions', only: ['edit', 'update']),
            // new Middleware('permission:delete permissions', only: ['destroy']),
        ];
    }

    //This method displays the permissions page
    public function index()
    {
        $permissions = Permission::orderBy('created_at', 'desc')->paginate(12);
        return view('backend.permissions.list', compact('permissions'));
    }

    public function create()
    {
        return view('backend.permissions.create');
    }

    public function store(Request $request)
    {
        $validator = validator::make($request->all(), [
            'name' => 'required|unique:permissions|min:3',
        ]);
        if ($validator->passes()) {
            Permission::create(['name' => $request->name]);
            return redirect()->route('permissions.index')->with('success', 'Permission created successfully');
        } else {
            return redirect()->route('permissions.create')->withErrors($validator)->withInput();
        }
    }

    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        return view('backend.permissions.edit', compact('permission'));
    }
    public function update($id, Request $request)
    {
        $permission = Permission::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:permissions,name,' . $id . ',id|min:3',
        ]);
        if ($validator->passes()) {
            $permission->update(['name' => $request->name]);
            return redirect()->route('permissions.index')->with('success', 'Permission updated successfully');
        } else {
            return redirect()->route('permissions.edit', $id)->withErrors($validator)->withInput();
        }
    }


    public function destroy(Request $request)
    {
        $id = $request->input('id');
        $permission = Permission::findOrFail($id);
        if ($permission ===  null) {
            session()->flash('error', 'Permission not found');
            return response()->json([
                'status' => false,
            ]);
        }
        $permission->delete();
        session()->flash('success', 'Permission deleted successfully');
        return response()->json([
            'status' => true,
        ]);
    }
}
