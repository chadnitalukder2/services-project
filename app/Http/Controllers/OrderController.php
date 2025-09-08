<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderCreated;
use App\Models\Invoice;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('customer', 'orderItems.service')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('backend.orders.list', compact('orders'));
    }

    public function create()
    {
        $customers = Customer::all();
        $services = Services::all();

        return view('backend.orders.create', compact('customers', 'services'));
    }
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|integer',
            'order_date' => 'required|date',
            'delivery_date' => 'required|date|after:order_date',
            'status' => 'required|in:pending,approved,cancelled,done',
            'total_amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:255',

            'services' => 'required|array|min:1',
            'services.*.id' => 'required|integer|exists:services,id',
            'services.*.quantity' => 'required|integer|min:1',
            'services.*.unit_price' => 'required|numeric|min:0',
            'services.*.subtotal' => 'required|numeric|min:0',

            'payment_method' => 'required|string|in:card,bkash,nagad,rocket,upay,cash_on_delivery',
            'payment_status' => 'required|string|in:pending,partial_paid,due,failed,refunded',
        ]);
        if ($validator->passes()) {
            $order = Order::create([
                'customer_id' => $request->customer_id,
                'order_date' => $request->order_date,
                'delivery_date' => $request->delivery_date,
                'status' => $request->status,
                'total_amount' => $request->total_amount,
                'notes' => $request->notes,
            ]);
            foreach ($request->services as $service) {
                $order->orderItems()->create([
                    'order_id' => $order->id,
                    'service_id' => $service['id'],
                    'quantity' => $service['quantity'],
                    'unit_price' => $service['unit_price'],
                    'subtotal' => $service['subtotal'],
                ]);
            }

            $invoice = Invoice::create([
                'order_id' => $order->id,
                'customer_id' => $request->customer_id,
                'amount' => $request->total_amount,
                'status' => $request->payment_status,
                'payment_method' => $request->payment_method,
            ]);

            return redirect()->route('orders.index')->with('success', 'Order created successfully');
        } else {
            return redirect()->route('orders.create')->withErrors($validator)->withInput();
        }
    }
}
