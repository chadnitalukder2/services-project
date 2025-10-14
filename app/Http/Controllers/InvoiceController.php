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
    public function index(Request $request)
    {
        // Start query
        $query = Invoice::with('customer')->orderBy('created_at', 'desc');

        // Filter by date range
        if ($request->filled('from_date')) {
            $formattedFrom = \Carbon\Carbon::createFromFormat('d-m-Y', $request->from_date)->format('Y-m-d');
            $query->whereDate('created_at', '>=', $formattedFrom);
        }
        if ($request->filled('to_date')) {
            $formattedTo = \Carbon\Carbon::createFromFormat('d-m-Y', $request->to_date)->format('Y-m-d');
            $query->whereDate('created_at', '<=', $formattedTo);
        }

        // Filter by customer
        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Paginate filtered results
        $invoices = $query->paginate(15)->withQueryString();

        // Totals for filtered invoices
        $totalAmount = $query->sum('amount');
        $totalPaid   = $query->sum('paid_amount');
        $totalDue    = $query->sum('due_amount');

        // For customer dropdown filter
        $customers = Customer::all();

        return view('backend.invoices.list', compact('invoices', 'totalAmount', 'totalPaid', 'totalDue', 'customers'));
    }


    public function processPayment(Request $request)
    {
        $id = $request->id;
        $invoice = Invoice::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|integer',
            'order_id' => 'required|integer',
            'expiry_date' => 'nullable|date',
            'amount' => 'nullable|numeric|min:0',
            'paid_amount' => 'nullable|numeric|min:0',
            'due_amount' => 'nullable|numeric|min:0',
            'payment_method' => 'nullable|string',
            'status' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $expiryDate = $request->expiry_date ? Carbon::createFromFormat('d-m-Y', $request->expiry_date)->format('Y-m-d') : null;

        if ($validator->passes()) {
            $invoice->customer_id = $request->customer_id;
            $invoice->order_id = $request->order_id;
            $invoice->expiry_date = $expiryDate;
            $invoice->amount = $request->amount;
            $invoice->paid_amount = $request->paid_amount;
            $invoice->due_amount = $request->due_amount;
            $invoice->status = $request->status;
            $invoice->payment_method = $request->payment_method;
            $invoice->save();

            return response()->json([
                'status' => true,
                'message' => 'Payment updated successfully',
            ]);
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
        $todayDate = Carbon::now()->format('d-m-Y');
        $customer = Customer::find($invoice->customer_id);
        $order = Order::with('orderItems.service', 'service')->find($invoice->order_id);
        $orderItems = $order->orderItems;

        return view('backend.invoices.generate-invoice', compact('invoice', 'todayDate', 'customer', 'order', 'orderItems'));
    }

    public function generateInvoice($id, $action = 'view')
    {
        $invoice = Invoice::findOrFail($id);
        $todayDate = Carbon::now()->format('d-m-Y');
        $customer = Customer::find($invoice->customer_id);
        $order = Order::with('orderItems.service', 'service')->find($invoice->order_id);

        $data = [
            'invoice' => $invoice,
            'todayDate' => $todayDate,
            'customer' => $customer,
            'order' => $order,
            'orderItems' => $order->orderItems
        ];

        $pdf = Pdf::loadView('backend.invoices.generate-invoice', $data);

        if ($action === 'download') {
            return $pdf->download('invoice-' . $invoice->id . '-' . $todayDate . '.pdf');
        }

        return $pdf->stream('invoice-' . $invoice->id . '-' . $todayDate . '.pdf');
    }
}
