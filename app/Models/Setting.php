<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'title',
        'address',
        'phone',
        'email',
        'currency',
        'currency_position',
        'logo',
        'message',
    ];
     public static function getSettings()
    {
        return static::first() ?: new static();
    }

    public static function updateOrCreateSettings(array $data)
    {
        $setting = static::first();
        
        if ($setting) {
            $setting->update($data);
        } else {
            $setting = static::create($data);
        }
        
        return $setting;
    }
}
