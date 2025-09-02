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
        return view('backend.roles.list');
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

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
