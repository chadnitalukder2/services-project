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
        $services = Services::where('status', 'active')->get();

        return view('backend.orders.create', compact('customers', 'services'));
    }
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|integer',
            'order_date' => 'required|date',
            'delivery_date' => 'required|date|after:order_date',
            'status' => 'nullable|string',
            'total_amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:255',

            'discount_type' => 'nullable|string',
            'discount_value' => 'nullable|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',

            'paid_amount' => 'nullable|numeric|min:0',
            'due_amount' => 'nullable|numeric|min:0',

            'services' => 'required|array|min:1',
            'services.*.id' => 'required|integer|exists:services,id',
            'services.*.quantity' => 'required|integer|min:1',
            'services.*.unit_price' => 'required|numeric|min:0',
            'services.*.subtotal' => 'required|numeric|min:0',

            'payment_method' => 'nullable|string',
            'payment_status' => 'nullable|string',
        ]);
        if ($validator->passes()) {
            $order = Order::create([
                'customer_id' => $request->customer_id,
                'order_date' => $request->order_date,
                'delivery_date' => $request->delivery_date,
                'status' => $request->status,
                'total_amount' => $request->total_amount,
                'discount_type' => $request->discount_type,
                'discount_value' => $request->discount_value,
                'discount_amount' => $request->discount_amount,
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
                'paid_amount' => $request->paid_amount,
                'due_amount' => $request->due_amount,
                'status' => $request->payment_status,
                'payment_method' => $request->payment_method,
            ]);

            return redirect()->route('orders.index')->with('success', 'Order created successfully');
        } else {
            return redirect()->route('orders.create')->withErrors($validator)->withInput();
        }
    }

    public function edit($id)
    {
        $order = Order::with(['orderItems.service', 'invoice'])->findOrFail($id);
        $customers = Customer::all();
        $services = Services::where('status', 'active')->get();

        return view('backend.orders.edit', compact('order', 'customers', 'services'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::with('orderItems', 'invoice')->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|integer',
            'order_date' => 'required|date',
            'delivery_date' => 'nullable|date|after:order_date',
            'status' => 'nullable|string',
            'total_amount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:255',

            'discount_type' => 'nullable|string',
            'discount_value' => 'nullable|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',

            'paid_amount' => 'nullable|numeric|min:0',
            'due_amount' => 'nullable|numeric|min:0',

            'services' => 'required|array|min:1',
            'services.*.id' => 'required|integer|exists:services,id',
            'services.*.quantity' => 'required|integer|min:1',
            'services.*.unit_price' => 'required|numeric|min:0',
            'services.*.subtotal' => 'required|numeric|min:0',

            'payment_method' => 'nullable|string',
            'payment_status' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update order
        $order->update([
            'customer_id' => $request->customer_id,
            'order_date' => $request->order_date,
            'delivery_date' => $request->delivery_date,
            'status' => $request->status,
            'total_amount' => $request->total_amount,
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'discount_amount' => $request->discount_amount,
            'notes' => $request->notes,
        ]);

        $existingItemIds = $order->orderItems->pluck('service_id')->toArray();
        $newItemIds = array_column($request->services, 'id');

        // Delete removed services
        foreach ($existingItemIds as $existingId) {
            if (!in_array($existingId, $newItemIds)) {
                $order->orderItems()->where('service_id', $existingId)->delete();
            }
        }

        // Add or update services
        foreach ($request->services as $service) {
            $orderItem = $order->orderItems()->where('service_id', $service['id'])->first();

            if ($orderItem) {
                $orderItem->update([
                    'order_id' => $order->id,
                    'service_id' => $service['id'],
                    'quantity' => $service['quantity'],
                    'unit_price' => $service['unit_price'],
                    'subtotal' => $service['subtotal'],
                ]);
            }
        }

        // Update or create invoice
        $invoice = $order->invoice;
        if ($invoice) {
            $invoice->update([
                'order_id' => $order->id,
                'customer_id' => $request->customer_id,
                'paid_amount' => $request->paid_amount,
                'due_amount' => $request->due_amount,
                'amount' => $request->total_amount,
                'status' => $request->payment_status,
                'payment_method' => $request->payment_method,
            ]);
        }

        return redirect()->route('orders.index')->with('success', 'Order updated successfully');
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'nullable|string'
        ]);

        try {
            $order->status = $request->status;
            $order->save();

            return response()->json([
                'status' => true,
                'success' => true,
                'message' => 'Order status updated successfully',
                'data' => [
                    'order_id' => $order->id,
                    'new_status' => $order->status
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'success' => false,
                'message' => 'Failed to update order status'
            ], 500);
        }
    }
}
