<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    protected $fillable = [
        'name',
        'category_id',
        'unit_price',
        'description',
        'status',
    ];

    public function category()
    {
        return $this->belongsTo(ServiceCategory::class);
    }
}
