<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Customer;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\ServiceCategory;
use App\Models\Services;
use App\Models\Setting;
use Sabberworm\CSS\Settings;

class ReportController extends Controller
{


    public function customerReport(Request $request)
    {
        $search = $request->search;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $sort = $request->get('sort', 'created_at');
        $order = $request->get('order', 'desc');

        $customers = Customer::query();

        if ($search) {
            $customers->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%")
                    ->orWhere('address', 'LIKE', "%{$search}%")
                    ->orWhere('company', 'LIKE', "%{$search}%");
            });
        }

        // get total orders and invoices for each customer and total paid amount from invoices and pending amount from invoices
        $customers->withCount(['orders', 'invoices'])
            ->withSum('invoices', 'paid_amount')
            ->withSum('invoices', 'due_amount')
            ->withSum('invoices', 'amount');



        if ($from_date) {
            $customers->whereDate('created_at', '>=', $from_date);
        }

        if ($to_date) {
            $customers->whereDate('created_at', '<=', $to_date);
        }

        $customers = $customers->orderBy($sort, $order)
            ->paginate(15)
            ->appends($request->query());

        $totalInvoices = $customers->sum('invoices_count');
        $totalOrders = $customers->sum('orders_count');
        $totalAmount = $customers->sum('invoices_sum_amount');
        $totalPaid   = $customers->sum('invoices_sum_paid_amount');
        $totalDue    = $customers->sum('invoices_sum_due_amount');

        return view('backend.reports.customer-reports', compact('customers', 'totalInvoices', 'totalOrders', 'totalAmount', 'totalPaid', 'totalDue'));
    }

    public function serviceReport(Request $request)
    {
        $query = Services::with('category');
        //search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('description', 'like', "%$search%");
            });
        }

        //Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Category filter
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Date range filter
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('created_at', [
                $request->from_date . " 00:00:00",
                $request->to_date . " 23:59:59"
            ]);
        } elseif ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        } elseif ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');

        $services = $query->orderBy($sort, $order)->paginate(15);

        $categories = ServiceCategory::all();

        $totalPrice = $query->sum('unit_price');

        return view('backend.reports.service-reports', compact('services', 'categories', 'totalPrice'));
    }


    public function orderReport(Request $request)
    {
        $query = Order::with('customer'); // eager load customer

        // Search filter (order ID, customer name, status)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id', $search)
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%");
                    });
            });
        }

        // Date filter
        if ($request->filled('from_date')) {
            $query->whereDate('order_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('order_date', '<=', $request->to_date);
        }

        // Sorting
        $sort = $request->get('sort', 'id'); // default sort by ID
        $order = $request->get('order', 'desc'); // default descending
        $allowedSort = ['id', 'order_date', 'delivery_date', 'status', 'total_amount'];
        if (!in_array($sort, $allowedSort)) $sort = 'id';
        if (!in_array($order, ['asc', 'desc'])) $order = 'desc';

        $query->orderBy($sort, $order);

        // Pagination
        $orders = $query->paginate(15)->appends($request->all());
        return view('backend.reports.order-reports', compact('orders'));
    }

    public function expenseReport(Request $request)
    {
        $query = Expense::query()->with('category');
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('from_date')) {
            $query->where('date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->where('date', '<=', $request->to_date);
        }

        $sort = $request->sort ?? 'date';
        $order = $request->order ?? 'desc';
        $query->orderBy($sort, $order);

        $expenses = $query->paginate(15)->withQueryString();

        $categories = ExpenseCategory::all();

        return view('backend.reports.expense-reports', compact('expenses', 'categories'));
    }

    public function invoiceReport(Request $request)
    {
        $query = Invoice::with('customer', 'order');

        // Filter by customer search
        if ($search = $request->search) {
            $query->whereHas('customer', function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhere('phone', 'like', "%$search%");
            });
        }

        // Filter by date
        if ($from = $request->from_date) {
            $query->whereDate('created_at', '>=', $from);
        }
        if ($to = $request->to_date) {
            $query->whereDate('created_at', '<=', $to);
        }

        // Sorting
        if ($sort = $request->sort) {
            $order = $request->order ?? 'asc';
            $query->orderBy($sort, $order);
        } else {
            $query->latest();
        }

        $invoices = $query->paginate(20);

        $settings = Setting::first();
        return view('backend.reports.invoice-reports', compact('invoices', 'settings'));
    }

    public function profitLossReport(Request $request)
    {

        return view('backend.reports.profit-loss-reports');
    }
}
