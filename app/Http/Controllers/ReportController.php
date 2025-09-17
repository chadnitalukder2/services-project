<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{


    public function index(Request $request)
    {
       
       return view('backend.reports.reports');
    }
  
}
