<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'title',
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
                try {
                    $formattedFrom = \Carbon\Carbon::createFromFormat('d-m-Y', $dateFrom)->format('Y-m-d');
                    return $query->whereDate('created_at', '>=', $formattedFrom);
                } catch (\Exception $e) {
                }
            })
            ->when($filters['date_to'] ?? false, function ($query, $dateTo) {
                try {
                    $formattedTo = \Carbon\Carbon::createFromFormat('d-m-Y', $dateTo)->format('Y-m-d');
                    return $query->whereDate('created_at', '<=', $formattedTo);
                } catch (\Exception $e) {
                }
            })
            ->when($filters['expense_date_from'] ?? false, function ($query, $dateFrom) {
                return $query->whereDate('date', '>=', $dateFrom);
            })
            ->when($filters['expense_date_to'] ?? false, function ($query, $dateTo) {
                return $query->whereDate('date', '<=', $dateTo);
            });
    }
}
