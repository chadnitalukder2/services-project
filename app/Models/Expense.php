<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'category_id',
        'date',
        'description',
        'amount',
    ];

    public function category()
    {
        return $this->belongsTo(ExpenseCategory::class);
    }

    public function scopeFilter($query, $filters)
    {
        return $query->when($filters['category_id'] ?? false, function ($query, $categoryId) {
            return $query->where('category_id', $categoryId);
        })
            ->when($filters['date_from'] ?? false, function ($query, $dateFrom) {
                return $query->whereDate('created_at', '>=', $dateFrom);
            })
            ->when($filters['date_to'] ?? false, function ($query, $dateTo) {
                return $query->whereDate('created_at', '<=', $dateTo);
            })
            ->when($filters['expense_date_from'] ?? false, function ($query, $dateFrom) {
                return $query->whereDate('date', '>=', $dateFrom);
            })
            ->when($filters['expense_date_to'] ?? false, function ($query, $dateTo) {
                return $query->whereDate('date', '<=', $dateTo);
            });
    }
}
