<?php

namespace App\Http\Controllers;

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

    $services = $query->paginate(15)->appends($request->query());

    return view('backend.services.list', compact('services'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.services.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'unit_price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'status' => 'required|string|in:active,inactive',
        ]);
        if ($validator->passes()) {
            $service = Services::create([
                'name' => $request->name,
                'unit_price' => $request->unit_price,
                'description' => $request->description,
                'status' => $request->status,
            ]);

            return redirect()->route('services.index')->with('success', 'Service created successfully');
        } else {
            return redirect()->route('services.create')->withErrors($validator)->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $service = Services::find($id);
        if ($service) {
            return view('backend.services.edit', compact('service'));
        } else {
            return redirect()->route('services.index')->with('error', 'Service not found');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $service = Services::find($id);
        if ($service) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'unit_price' => 'required|numeric|min:0',
                'description' => 'nullable|string',
                'status' => 'required|string|in:active,inactive',
            ]);
            if ($validator->passes()) {
                $service->update([
                    'name' => $request->name,
                    'unit_price' => $request->unit_price,
                    'description' => $request->description,
                    'status' => $request->status,
                ]);
                return redirect()->route('services.index')->with('success', 'Service updated successfully');
            } else {
                return redirect()->route('services.edit', $id)->withErrors($validator)->withInput();
            }
        } else {
            return redirect()->route('services.index')->with('error', 'Service not found');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
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
