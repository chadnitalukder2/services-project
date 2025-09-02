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
        return view('permissions.list');
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

     public function edit()
    {

    }
         public function update()
    {
      
    }


         public function destroy()
    {
        return view('permissions.index');
    }

}
