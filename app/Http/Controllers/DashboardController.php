<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Invoice;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{


    public function index()
    {
        $totalRevenue   = Invoice::sum('paid_amount');
        $totalExpenses  = Expense::sum('amount');
        $netProfit      = $totalRevenue - $totalExpenses;

        $pendingInvoices = Invoice::where(function ($q) {
            $q->where('status', 'pending')
                ->orWhere('due_amount', '>', 0);
        })->count();

        $outstanding = Invoice::where(function ($q) {
            $q->where('status', 'pending')
                ->orWhere('due_amount', '>', 0);
        })->sum('due_amount');

        $monthlyRevenue = Invoice::selectRaw('MONTH(created_at) as month, SUM(amount) as total')
            ->groupBy('month')
            ->pluck('total', 'month');

        $monthlyExpenses = Expense::selectRaw('MONTH(date) as month, SUM(amount) as total')
            ->groupBy('month')
            ->pluck('total', 'month');


        $orderStatus = Order::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');


        $thisMonthRevenue = Invoice::whereMonth('created_at', Carbon::now()->month)
            ->sum('amount');
        $lastMonthRevenue = Invoice::whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->sum('amount');

        $revenueGrowth = $lastMonthRevenue > 0
            ? (($thisMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100
            : 0;

        // 🔹 Expenses: this month vs last month
        $thisMonthExpenses = Expense::whereMonth('date', Carbon::now()->month)
            ->sum('amount');
        $lastMonthExpenses = Expense::whereMonth('date', Carbon::now()->subMonth()->month)
            ->sum('amount');

        $expenseGrowth = $lastMonthExpenses > 0
            ? (($thisMonthExpenses - $lastMonthExpenses) / $lastMonthExpenses) * 100
            : 0;

        return view('dashboard', compact(
            'totalRevenue',
            'totalExpenses',
            'netProfit',
            'pendingInvoices',
            'outstanding',
            'monthlyRevenue',
            'monthlyExpenses',
            'orderStatus',
            'revenueGrowth',
            'expenseGrowth'
        ));
    }
}
