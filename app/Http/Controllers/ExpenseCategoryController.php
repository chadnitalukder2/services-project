<?php

namespace App\Http\Controllers;

use App\Models\ExpenseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ExpenseCategoryController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view expense categories', only: ['index', 'show']),
            new Middleware('permission:create expense categories', only: ['create', 'store']),
            new Middleware('permission:edit expense categories', only: ['edit', 'update']),
            new Middleware('permission:delete expense categories', only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $expenseCategories = ExpenseCategory::orderBy('created_at', 'desc')->paginate(12);
        return view('backend.expense_categories.list', compact('expenseCategories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:expense_categories,name|min:3',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $category = ExpenseCategory::create([
            'name' => $request->name
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Expense Category saved successfully',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $category = ExpenseCategory::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:expense_categories,name,' . $id . '|min:3',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $category->name = $request->name;
        $category->save();

        return response()->json([
            'status' => true,
            'message' => 'Expense Category updated successfully',
        ]);
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
