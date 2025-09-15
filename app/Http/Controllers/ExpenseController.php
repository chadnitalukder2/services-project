<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ExpenseController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view expenses', only: ['index', 'show']),
            new Middleware('permission:create expenses', only: ['create', 'store']),
            new Middleware('permission:edit expenses', only: ['edit', 'update']),
            new Middleware('permission:delete expenses', only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $expenses = Expense::with('category')
            ->filter($request->only(['category_id', 'date_from', 'date_to', 'expense_date_from', 'expense_date_to']))
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->appends($request->query());

        $categories = ExpenseCategory::orderBy('created_at', 'asc')->get();
        $expenseCategories = ExpenseCategory::orderBy('created_at', 'asc')->get();

        return view('backend.expenses.list', compact('expenses', 'categories', 'expenseCategories'));
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
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }
        $expense = Expense::create([
            'category_id' => $request->category_id,
            'amount' => $request->amount,
            'date' => $request->date,
            'description' => $request->description,
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Expense created successfully',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $category = Expense::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:expense_categories,id',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'description' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

            $category->category_id = $request->category_id;
            $category->amount = $request->amount;
            $category->date = $request->date;
            $category->description = $request->description;
            $category->save();

          return response()->json([
            'status' => true,
            'message' => 'Expense  updated successfully',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $expense = Expense::find($request->id);
        if ($expense) {
            $expense->delete();
            return response()->json(['status' => true, 'message' => 'Expense deleted successfully']);
        } else {
            return response()->json(['status' => false, 'message' => 'Expense not found']);
        }
    }
}
