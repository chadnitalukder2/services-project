<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{


    public function customerReport(Request $request)
    {
       
       return view('backend.reports.customer-reports');
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

       return view('backend.reports.expense-reports');
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
