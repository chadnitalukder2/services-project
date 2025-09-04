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
    public function index()
    {
        $customers = Customer::orderBy('created_at', 'desc')->paginate(10);
        return view('backend.customers.list', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|unique:customers,email',
            'phone' => 'required|numeric|min:0',
            'address' => 'required|string',
            'company' => 'nullable|string',
        ]);
        if ($validator->passes()) {
            $customer = Customer::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'company' => $request->company,
            ]);

            return redirect()->route('customers.index')->with('success', 'Customer created successfully');
        } else {
            return redirect()->route('customers.create')->withErrors($validator)->withInput();
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $customer = Customer::find($id);
        if ($customer) {
            return view('backend.customers.edit', compact('customer'));
        } else {
            return redirect()->route('customers.index')->with('error', 'Customer not found');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $customer = Customer::find($id);
        if ($customer) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:customers,email,' . $id,
                'phone' => 'required|numeric|min:0',
                'address' => 'required|string',
                'company' => 'nullable|string',
            ]);
            if ($validator->passes()) {
                $customer->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'company' => $request->company,
                ]);
                return redirect()->route('customers.index')->with('success', 'Customer updated successfully');
            } else {
                return redirect()->route('customers.edit', $id)->withErrors($validator)->withInput();
            }
        } else {
            return redirect()->route('customers.index')->with('error', 'Customer not found');
        }
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
