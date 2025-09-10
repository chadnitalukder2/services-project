<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoice::with('customer')->orderBy('created_at', 'desc')->paginate(15);
        return view('backend.invoices.list', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
    public function processPayment(Request $request)
    {
        $id = $request->id ;
         $invoice = Invoice::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|integer',
            'order_id' => 'required|integer',
            'amount' => 'nullable|numeric|min:0',
            'paid_amount' => 'nullable|numeric|min:0',
            'due_amount' => 'nullable|numeric|min:0',
            'payment_method' => 'nullable|string',
            'status' => 'nullable|string',
        ]);
 
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if($validator->passes()){
            $invoice->customer_id = $request->customer_id;
            $invoice->order_id = $request->order_id;
            $invoice->amount = $request->amount;
            $invoice->paid_amount = $request->paid_amount;
            $invoice->due_amount = $request->due_amount;
            $invoice->status = $request->status;
            $invoice->payment_method = $request->payment_method;
            $invoice->save();


            return redirect()->route('invoices.index')->with('success', 'Invoice updated successfully');
        }else{
            //return redirect()->route('invoices.edit', $invoice->id)->withErrors($validator)->withInput();
        }

    }

   
}
