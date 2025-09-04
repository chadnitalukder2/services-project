<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $expenses = Expense::orderBy('name', 'asc')->paginate(10);
        return view('backend.expenses.list', compact('expenses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $expenseCategories = ExpenseCategory::orderBy('created_at', 'asc')->get();
         return view('backend.expenses.create', compact('expenseCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:expense_categories,id',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'description' => 'nullable|string|max:255',
        ]);
        if($validator->passes()){
            $expense = Expense::create([
                'category_id' => $request->category_id,
                'amount' => $request->amount,
                'date' => $request->date,
                'description' => $request->description,
            ]);

            return redirect()->route('expenses.index')->with('success', 'Expense added successfully');
        }else{
            return redirect()->route('expenses.create')->withErrors($validator)->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $Expense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id)
    {
        $category = Expense::find($id);
        if ($category) {
            return view('backend.expense_categories.edit', compact('category'));
        } else {
            return redirect()->route('expense_categories.index')->with('error', 'Category not found');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
         $category = Expense::findOrFail($id);

         $validator = Validator::make($request->all(), [
            'name' => 'required|unique:expense_categories,name,' . $id . ',id|min:3',
        ]);
        if($validator->passes()){
     
            $category->name = $request->name;
            $category->save();

            return redirect()->route('expense_categories.index')->with('success', 'Expense Category updated successfully');
        }else{
            return redirect()->route('expense_categories.edit', $id)->withErrors($validator)->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
          $category = Expense::find($request->id);
        if ($category) {
            $category->delete();
            return response()->json(['status' => true, 'message' => 'Expense Category deleted successfully']);
        } else {
            return response()->json(['status' => false, 'message' => 'Expense Category not found']);
        }
    }
}
