<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
    protected $fillable = [
        'order_id',
        'service_id',
        'quantity',
        'unit_price',
        'subtotal',
    ];

    public function service()
    {
        return $this->belongsTo(Services::class, 'service_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
