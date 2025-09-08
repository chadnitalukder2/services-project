<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_id',
        'order_date',
        'delivery_date',
        'status',
        'total_amount',
        'notes',
    ];
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function orderItems()
    {
        return $this->hasMany(OrderItems::class);
    }

    public function service()
    {
        return $this->belongsTo(Services::class);
    }
}
