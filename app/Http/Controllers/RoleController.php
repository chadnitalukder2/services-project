<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::orderBy('name', 'asc')->paginate(10);
        return view('backend.roles.list', [
            'roles' => $roles
        ]);
    }

    public function create()
    {
        $permissions = Permission::orderBy('name', 'asc')->get();
        return view('backend.roles.create',[
            'permissions' => $permissions
        ]);
    }

    public function store(Request $request)
    {
      $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles|min:3',
        ]);
        if($validator->passes()){
            $role = Role::create(['name' => $request->name]);

            if(!empty($request->permissions)){
                foreach($request->permissions as $name){
                    $role->givePermissionTo($name);
                }
            }

            return redirect()->route('roles.index')->with('success', 'Role added successfully');
        }else{
            return redirect()->route('roles.create')->withErrors($validator)->withInput();
        }
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $hasPermissions = $role->permissions->pluck('name');
        $permissions = Permission::orderBy('name', 'asc')->get();
        return view('backend.roles.edit', [
            'role' => $role,
            'permissions' => $permissions,
            'hasPermissions' => $hasPermissions
        ]);
    }

    public function update($id, Request $request)
    {
        $role = Role::findOrFail($id);
        
         $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name,' . $id . ',id|min:3',
        ]);
        if($validator->passes()){
     
            $role->name = $request->name;
            $role->save();

            if(!empty($request->permissions)){
              $role->syncPermissions($request->permissions);
            }else{
                $role->syncPermissions([]);
            }

            return redirect()->route('roles.index')->with('success', 'Role updated successfully');
        }else{
            return redirect()->route('roles.edit', $id)->withErrors($validator)->withInput();
        }
        
    }

    public function destroy(Request $request)
    {
        $id = $request->input('id');
        $role = Role::findOrFail($id);
        if($role ===  null){
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
