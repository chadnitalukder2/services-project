<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class InvoiceController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view invoices', only: ['index', 'show']),
            new Middleware('permission:payment invoices', only: ['processPayment']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoice::with('customer')->orderBy('created_at', 'desc')->paginate(15);
        return view('backend.invoices.list', compact('invoices'));
    }


    public function processPayment(Request $request)
    {
        $id = $request->id;
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

        if ($validator->passes()) {
            $invoice->customer_id = $request->customer_id;
            $invoice->order_id = $request->order_id;
            $invoice->amount = $request->amount;
            $invoice->paid_amount = $request->paid_amount;
            $invoice->due_amount = $request->due_amount;
            $invoice->status = $request->status;
            $invoice->payment_method = $request->payment_method;
            $invoice->save();


            return redirect()->route('invoices.index')->with('success', 'Invoice updated successfully');
        } else {
            //return redirect()->route('invoices.edit', $invoice->id)->withErrors($validator)->withInput();
        }
    }

    public function destroy(Request $request)
    {
        $invoice = Invoice::findOrFail($request->id);
        if ($invoice) {
            $invoice->delete();
            return response()->json(['status' => true, 'message' => 'Invoice deleted successfully']);
        } else {
            return response()->json(['status' => false, 'message' => 'Invoice not found']);
        }
    }
}
