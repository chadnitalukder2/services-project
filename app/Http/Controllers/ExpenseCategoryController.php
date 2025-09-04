<?php

namespace App\Http\Controllers;

use App\Models\ExpenseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ExpenseCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $expenseCategories = ExpenseCategory::orderBy('name', 'asc')->paginate(10);
        return view('backend.expense_categories.list', compact('expenseCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('backend.expense_categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $validator = Validator::make($request->all(), [
             'name' => 'required|unique:expense_categories,name|min:3',
        ]);
        if($validator->passes()){
            $category = ExpenseCategory::create(['name' => $request->name]);

            return redirect()->route('expense_categories.index')->with('success', 'Expense Category added successfully');
        }else{
            return redirect()->route('expense_categories.create')->withErrors($validator)->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ExpenseCategory $expenseCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id)
    {
        $category = ExpenseCategory::find($id);
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
         $category = ExpenseCategory::findOrFail($id);

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
          $category = ExpenseCategory::find($request->id);
        if ($category) {
            $category->delete();
            return response()->json(['status' => true, 'message' => 'Expense Category deleted successfully']);
        } else {
            return response()->json(['status' => false, 'message' => 'Expense Category not found']);
        }
    }
}
