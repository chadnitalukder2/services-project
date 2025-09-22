<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Customer;
use App\Models\Expense;
use App\Models\ExpenseCategory;

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

        return view('backend.reports.customer-reports', compact('customers'));
    }

    public function serviceReport(Request $request)
    {

        return view('backend.reports.service-reports');
    }

    public function orderReport(Request $request)
    {

        return view('backend.reports.order-reports');
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

        return view('backend.reports.invoice-reports');
    }

    public function profitLossReport(Request $request)
    {

        return view('backend.reports.profit-loss-reports');
    }
}
