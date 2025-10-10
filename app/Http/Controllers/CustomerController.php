<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CustomerController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view customers', only: ['index', 'show']),
            new Middleware('permission:create customers', only: ['create', 'store']),
            new Middleware('permission:edit customers', only: ['edit', 'update']),
            new Middleware('permission:delete customers', only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $query = Customer::query();

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('email', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('phone', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('address', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('company', 'LIKE', "%{$searchTerm}%");
            });
        }

        $sortOrder = $request->get('sort', 'desc');
        if (in_array($sortOrder, ['asc', 'desc'])) {
            $query->orderBy('created_at', $sortOrder);
        } else {
            $query->orderBy('created_at', 'desc');
        }
        $customers = $query->paginate(15)->appends($request->query());

        return view('backend.customers.list', compact('customers'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'required',
            'address' => 'nullable|string',
            'company' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        
        $customer = Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'company' => $request->company,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Customer saved successfully',
        ]);
    }
    public function OrderCustomerStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'required',
            'address' => 'nullable|string',
            'company' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $customer = Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'company' => $request->company,
        ]);

        return response()->json([
            'status' => true,
            'customer' => $customer,
            'message' => 'Customer added successfully'
        ]);
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json([
                'status' => false,
                'message' => 'Customer not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'required',
            'address' => 'nullable|string',
            'company' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $customer->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'company' => $request->company,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Customer updated successfully',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $customer = Customer::findOrFail($request->id);
        if ($customer) {
            $customer->delete();
            return response()->json(['status' => true, 'message' => 'Customer deleted successfully']);
        } else {
            return response()->json(['status' => false, 'message' => 'Customer not found']);
        }
    }
}
