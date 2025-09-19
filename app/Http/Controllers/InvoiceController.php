<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

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

    public function viewInvoice($id)
    {
        $invoice = Invoice::findOrFail($id);
        $setting = Setting::getSettings();
        return view('backend.invoices.generate-invoice', compact('invoice', 'setting'));
    }

    public function generateInvoice($id, $action = 'view')
    {
        $invoice = Invoice::findOrFail($id);
        $todayDate = Carbon::now()->format('d-m-Y');
        $customer = Customer::find($invoice->customer_id);
        $order = Order::with('orderItems.service', 'service')->find($invoice->order_id);
        $expiryDate = Carbon::now()->addDays(7)->format('d-m-Y');

        $data = [
            'invoice' => $invoice,
            'todayDate' => $todayDate,
            'expiryDate' => $expiryDate,
            'customer' => $customer,
            'order' => $order,
            'orderItems' => $order->orderItems
        ];

        $pdf = Pdf::loadView('backend.invoices.generate-invoice', $data);

        if ($action === 'download') {
            return $pdf->download('invoice-' . $invoice->id . '-' . $todayDate . '.pdf');
        }

        // Default: open in browser (printable)
        return $pdf->stream('invoice-' . $invoice->id . '-' . $todayDate . '.pdf');
    }
}
