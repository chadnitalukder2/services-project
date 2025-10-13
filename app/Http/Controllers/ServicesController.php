<?php

namespace App\Http\Controllers;

use App\Models\ServiceCategory;
use App\Models\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ServicesController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view services', only: ['index', 'show']),
            new Middleware('permission:create services', only: ['create', 'store']),
            new Middleware('permission:edit services', only: ['edit', 'update']),
            new Middleware('permission:delete services', only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Services::query();

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where('name', 'LIKE', "%{$searchTerm}%");
            $query->where('name', 'LIKE', "%{$searchTerm}%");
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('price_min')) {
            $query->where('unit_price', '>=', $request->price_min);
        }

        if ($request->filled('price_max')) {
            $query->where('unit_price', '<=', $request->price_max);
        }

        // Handle sorting and status filtering
        $sort = $request->get('sort', 'desc');

        if ($sort === 'active') {
            $query->where('status', 'active')->orderBy('created_at', 'desc');
        } elseif ($sort === 'inactive') {
            $query->where('status', 'inactive')->orderBy('created_at', 'desc');
        } elseif (in_array($sort, ['asc', 'desc'])) {
            $query->orderBy('created_at', $sort);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $services = $query->with('category')
            ->paginate(12)
            ->appends($request->query());

        $serviceCategories = ServiceCategory::orderBy('created_at', 'desc')->get();

        return view('backend.services.list', compact('services', 'serviceCategories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|exists:service_categories,id',
            'unit_price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'status' => 'required|string|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $service = Services::create([
            'name' => $request->name,
            'unit_price' => $request->unit_price,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Service saved successfully',
        ]);
    }
    public function update(Request $request, string $id)
    {
        $service = Services::find($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|exists:service_categories,id',
            'unit_price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'status' => 'required|string|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $service->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'unit_price' => $request->unit_price,
            'description' => $request->description,
            'status' => $request->status,
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Service  updated successfully',
        ]);
    }
    public function destroy(Request $request)
    {
        $service = Services::find($request->id);
        if ($service) {
            $service->delete();
            return response()->json(['status' => true, 'message' => 'Service deleted successfully']);
        } else {
            return response()->json(['status' => false, 'message' => 'Service not found']);
        }
    }
}
