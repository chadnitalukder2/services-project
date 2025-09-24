<?php

namespace App\Http\Controllers;

use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ServiceCategoryController extends Controller implements HasMiddleware
{
 
        public static function middleware(): array
    {
        return [
            new Middleware('permission:view service category', only: ['index', 'show']),
            new Middleware('permission:create service category', only: ['create', 'store']),
            new Middleware('permission:edit service category', only: ['edit', 'update']),
            new Middleware('permission:delete service category', only: ['destroy']),
        ];
    }
    public function index()
    {
        $serviceCategory = ServiceCategory::orderBy('created_at', 'desc')->paginate(12);
        return view('backend.services_category.list', compact('serviceCategory'));
    }

    public function store(Request $request)
    {
    
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:service_categories,name|min:3',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $category = ServiceCategory::create([
            'name' => $request->name
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Service Category saved successfully',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $category = ServiceCategory::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:service_categories,name,' . $id . '|min:3',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $category->name = $request->name;
        $category->save();

        return response()->json([
            'status' => true,
            'message' => 'Service Category updated successfully',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $category = ServiceCategory::find($request->id);
        if ($category) {
            $category->delete();
            return response()->json(['status' => true, 'message' => 'Service Category deleted successfully']);
        } else {
            return response()->json(['status' => false, 'message' => 'Service Category not found']);
        }
    }
}
