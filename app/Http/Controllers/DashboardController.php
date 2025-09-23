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
        // Total Revenue (approved এবং done status orders)
        $totalRevenue = Order::whereIn('status', ['approved', 'done'])
            ->sum('total_amount');

        // Total Expenses
        $totalExpenses  = Expense::sum('amount');

        // Net Profit
        $netProfit      = $totalRevenue - $totalExpenses;

        // Pending Invoices
        $pendingOrder = Order::where(function ($q) {
            $q->where('status', 'pending');
        })->count();

        // Outstanding Amount
        $outstanding = Order::where(function ($q) {
            $q->where('status', 'pending');
        })->sum('total_amount');

        $year = now()->year;

        // Monthly Revenue (Order table)
        $monthlyRevenue = Order::selectRaw('MONTH(order_date) as month, SUM(total_amount) as total')
            ->whereYear('order_date', $year)
            ->whereIn('status', ['approved', 'done'])
            ->groupBy('month')
            ->pluck('total', 'month');

        // Monthly Expenses (Expense table)
        $monthlyExpenses = Expense::selectRaw('MONTH(date) as month, SUM(amount) as total')
            ->whereYear('date', $year)
            ->groupBy('month')
            ->pluck('total', 'month');

        // Fill missing months with 0
        $allMonths = collect(range(1, 12));
        $monthlyRevenue = $allMonths->mapWithKeys(fn($m) => [$m => $monthlyRevenue[$m] ?? 0]);
        $monthlyExpenses = $allMonths->mapWithKeys(fn($m) => [$m => $monthlyExpenses[$m] ?? 0]);

        // Current and Last Month
        $currentMonth = now()->month;
        $lastMonth    = now()->subMonth()->month;

        // This Month and Last Month Revenue
        $thisMonthRevenue = $monthlyRevenue[$currentMonth];
        $lastMonthRevenue = $monthlyRevenue[$lastMonth] ?? 0;

        // Revenue Growth
        $revenueGrowth = $lastMonthRevenue > 0
            ? (($thisMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100
            : ($thisMonthRevenue > 0 ? 100 : 0);

        // This Month and Last Month Expenses
        $thisMonthExpenses = $monthlyExpenses[$currentMonth];
        $lastMonthExpenses = $monthlyExpenses[$lastMonth] ?? 0;

        // Expense Growth
        $expenseGrowth = $lastMonthExpenses > 0
            ? (($thisMonthExpenses - $lastMonthExpenses) / $lastMonthExpenses) * 100
            : ($thisMonthExpenses > 0 ? 100 : 0);

        // This Month and Last Month Profit
        $thisMonthProfit = $thisMonthRevenue - $thisMonthExpenses;
        $lastMonthProfit = $lastMonthRevenue - $lastMonthExpenses;

        // Profit Growth
        $profitGrowth = $lastMonthProfit != 0
            ? (($thisMonthProfit - $lastMonthProfit) / abs($lastMonthProfit)) * 100
            : ($thisMonthProfit != 0 ? 100 : 0);

        // Order Statuses
        $statuses = ['pending', 'approved', 'done', 'canceled'];
        $orderStatusRaw = Order::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        // Fill missing statuses with 0
        $orderStatus = collect($statuses)->mapWithKeys(fn($s) => [$s => $orderStatusRaw[$s] ?? 0]);

        // Send all data to dashboard view
        return view('dashboard', compact(
            'totalRevenue',
            'totalExpenses',
            'netProfit',
            'pendingOrder',
            'outstanding',
            'monthlyRevenue',
            'monthlyExpenses',
            'orderStatus',
            'revenueGrowth',
            'expenseGrowth',
            'profitGrowth'
        ));
    }
}
