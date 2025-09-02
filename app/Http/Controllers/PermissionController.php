<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    //This method displays the permissions page
    public function index()
    {
        $permissions = Permission::orderBy('created_at', 'desc')->paginate(4);
        return view('permissions.list', compact('permissions'));
    }

     public function create()
    {
        return view('permissions.create');
    }

     public function store(Request $request)
    {
        $validator = validator::make($request->all(), [
            'name' => 'required|unique:permissions|min:3',
        ]);
        if($validator->passes()){
            Permission::create(['name' => $request->name]);
            return redirect()->route('permissions.index')->with('success', 'Permission created successfully');
        }else{
            return redirect()->route('permissions.create')->withErrors($validator)->withInput();
        }
    }

     public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        return view('permissions.edit', compact('permission'));
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


         public function destroy()
    {
        return view('permissions.index');
    }

}
