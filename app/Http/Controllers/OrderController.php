<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderCreated;
use App\Models\Invoice;
use App\Models\ServiceCategory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class OrderController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view orders', only: ['index', 'show']),
            new Middleware('permission:create orders', only: ['create', 'store']),
            new Middleware('permission:edit orders', only: ['edit', 'update']),
            new Middleware('permission:delete orders', only: ['destroy']),
        ];
    }
    public function index(Request $request)
    {
        $query = Order::query();
        $ordersTotal =  Order::get();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('from_date')) {
            $fromDate = \Carbon\Carbon::createFromFormat('d-m-Y', $request->from_date);
            $query->whereDate('created_at', '>=', $fromDate);
        }

        if ($request->filled('to_date')) {
            $toDate = \Carbon\Carbon::createFromFormat('d-m-Y', $request->to_date);
            $query->whereDate('created_at', '<=', $toDate);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(12);
        $orders->getCollection()->transform(function ($order) {
            if ($order->custom_fields) {
                $order->custom_fields = json_decode($order->custom_fields, true); // decode JSON string to array
            } else {
                $order->custom_fields = [];
            }
            return $order;
        });

        $totalOrders = (clone $ordersTotal)->count();
        $pendingOrders = (clone $ordersTotal)->where('status', 'pending')->count();
        $completedOrders = (clone  $ordersTotal)->whereIn('status', ['approved', 'done'])->count();

        $totalRevenue = (clone $ordersTotal)->whereIn('status', ['approved', 'done'])->sum('total_amount');

        $summary = [
            'total_orders' => $totalOrders,
            'pending_orders' => $pendingOrders,
            'completed_orders' => $completedOrders,
            'total_revenue' => number_format($totalRevenue, 2)
        ];
        $totalOrderAmount = Order::sum('total_amount');


        return view('backend.orders.list', compact('orders', 'summary', 'totalOrderAmount'));
    }

    public function create()
    {
       $customers = Customer::orderBy('created_at', 'desc')->get();
        $services = Services::where('status', 'active')->orderBy('created_at', 'desc')->get();
        $serviceCategories = ServiceCategory::orderBy('created_at', 'desc')->get();
        return view('backend.orders.create', compact('customers', 'services', 'serviceCategories'));
    }
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|integer',
            'order_date' => 'required',
            'delivery_date' => 'required|after:order_date',
            'status' => 'nullable|string',
            'total_amount' => 'nullable|numeric|min:0',
            'subtotal' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',

            // Custom fields validation
            'custom_fields' => 'nullable|array',
            'custom_fields.*.event_name' => 'nullable|string',
            'custom_fields.*.event_date' => 'nullable|date',
            'custom_fields.*.event_time' => 'nullable',

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

            'expiry_date' => 'nullable',
            'payment_method' => 'nullable|string',
            'payment_status' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $customFieldsData = null;
        if ($request->custom_fields) {
            $customFieldsData = json_encode($request->custom_fields);
        }

        if ($validator->passes()) {
            $orderDate = \Carbon\Carbon::createFromFormat('d-m-Y', $request->order_date)->format('Y-m-d');
            $deliveryDate = \Carbon\Carbon::createFromFormat('d-m-Y', $request->delivery_date)->format('Y-m-d');
            $expiryDate = \Carbon\Carbon::createFromFormat('d-m-Y', $request->expiry_date)->format('Y-m-d');

            $order = Order::create([
                'customer_id' => $request->customer_id,
                'order_date' => $orderDate,
                'delivery_date' => $deliveryDate,
                'status' => $request->status,
                'subtotal' => $request->subtotal,
                'total_amount' => $request->total_amount,
                'discount_type' => $request->discount_type,
                'discount_value' => $request->discount_value,
                'discount_amount' => $request->discount_amount,
                'custom_fields' => $customFieldsData,
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
                'expiry_date' => $expiryDate,
                'customer_id' => $request->customer_id,
                'amount' => $request->total_amount,
                'paid_amount' => $request->paid_amount,
                'due_amount' => $request->due_amount,
                'status' => $request->payment_status,
                'payment_method' => $request->payment_method,
            ]);

            return redirect()->route('orders.index')->with('success', 'Order saved successfully');
        } else {
            return redirect()->route('orders.create')->withErrors($validator)->withInput();
        }
    }

    public function edit($id)
    {
        $order = Order::with(['orderItems.service', 'invoice'])->findOrFail($id);
        $customers = Customer::orderBy('created_at', 'desc')->get();
        $services = Services::where('status', 'active')->orderBy('created_at', 'desc')->get();
        $serviceCategories = ServiceCategory::orderBy('created_at', 'desc')->get();
        // Decode custom fields if they exist
        $customFields = null;
        if ($order->custom_fields) {
            $customFields = json_decode($order->custom_fields, true);
        }

        return view('backend.orders.edit', compact('order', 'customers', 'services', 'customFields', 'serviceCategories'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::with('orderItems', 'invoice')->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|integer',
            'order_date' => 'required',
            'delivery_date' => 'required|after:order_date',
            'status' => 'nullable|string',
            'total_amount' => 'nullable|numeric|min:0',
            'subtotal' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',

            // Custom fields validation
            'custom_fields' => 'nullable|array',
            'custom_fields.*.event_name' => 'nullable|string',
            'custom_fields.*.event_date' => 'nullable|date',
            'custom_fields.*.event_time' => 'nullable',

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

            'expiry_date' => 'nullable',
            'payment_method' => 'nullable|string',
            'payment_status' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            dd($request->all(), $validator->errors());
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $customFieldsData = null;
        if ($request->custom_fields) {
            $customFieldsData = json_encode($request->custom_fields);
        }

        $orderDate = \Carbon\Carbon::createFromFormat('d-m-Y', $request->order_date)->format('Y-m-d');
        $deliveryDate = \Carbon\Carbon::createFromFormat('d-m-Y', $request->delivery_date)->format('Y-m-d');
        $expiryDate = \Carbon\Carbon::createFromFormat('d-m-Y', $request->expiry_date)->format('Y-m-d');

        $order->update([
            'customer_id' => $request->customer_id,
            'order_date' => $orderDate,
            'delivery_date' => $deliveryDate,
            'status' => $request->status,
            'subtotal' => $request->subtotal,
            'total_amount' => $request->total_amount,
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'discount_amount' => $request->discount_amount,
            'custom_fields' => $customFieldsData,
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
                // update existing
                $orderItem->update([
                    'quantity' => $service['quantity'],
                    'unit_price' => $service['unit_price'],
                    'subtotal' => $service['subtotal'],
                ]);
            } else {
                $order->orderItems()->create([
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
                'expiry_date' => $expiryDate,
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

    public function destroy(Request $request)
    {
        $order = Order::findOrFail($request->id);
        if ($order) {
            $order->orderItems()->delete();
            if ($order->invoice) {
                $order->invoice->delete();
            }
            $order->delete();
            return response()->json(['status' => true, 'message' => 'Order deleted successfully']);
        } else {
            return response()->json(['status' => false, 'message' => 'Order not found']);
        }
    }
}
