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
        $query = Order::with('customer');

        // Search filter 
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
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');
        $orders = $query->orderBy($sort, $order)->paginate(15);

        //  Summary counts
        $summary = [
            'total_orders'       => Order::count(),
            'total_amount' => Order::sum('total_amount'),

            'pending_orders'     => Order::where('status', 'pending')->count(),
            'pending_amount'     => Order::where('status', 'pending')->sum('total_amount'),

            'completed_order'    => Order::whereIn('status', ['approved', 'done'])->count(),
            'completed_amount'   => Order::whereIn('status', ['approved', 'done'])->sum('total_amount'),

            'cancelled_orders'   => Order::where('status', 'canceled')->count(),
            'cancelled_amount'   => Order::where('status', 'canceled')->sum('total_amount'),
        ];

        return view('backend.reports.order-reports', compact('orders', 'summary'));
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

        $invoices = $query->paginate(15);
        $paidInvoices = Invoice::where('status', 'paid');
        $partialInvoices = Invoice::where('status', 'partial');
        $dueInvoices = Invoice::where('status', 'due');

        $summary = [
            'paid_count'    => $paidInvoices->count(),
            'paid_amount'   => Invoice::sum('paid_amount'),

            'partial_count' => $partialInvoices->count(),
            'partial_amount' => $partialInvoices->sum('due_amount'),

            'due_count'     => $dueInvoices->count(),
            'due_amount'    => Invoice::sum('due_amount'),
        ];

        $settings = Setting::first();
        return view('backend.reports.invoice-reports', compact('invoices', 'settings', 'summary'));
    }

    public function profitLossReport(Request $request)
    {
             $startDate = $request->input('start_date');
        $endDate   = $request->input('end_date');

        // Orders: only approved or done
        $orders = Order::whereIn('status', ['approved', 'done'])
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereBetween('order_date', [$startDate, $endDate]);
            })
            ->sum('total_amount');

        // Expenses
        $expenses = Expense::when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereBetween('date', [$startDate, $endDate]);
            })
            ->sum('amount');

        // Profit / Loss
        $profitLoss = $orders - $expenses;
        return view('backend.reports.profit-loss-reports', compact('orders', 'expenses', 'profitLoss', 'startDate', 'endDate'));
    }
}
