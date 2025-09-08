<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'customer_id' => 'required|exists:users,id',
            'order_date' => 'required|date',
            'delivery_date' => 'nullable|date|after_or_equal:order_date',
            'notes' => 'nullable|string|max:1000',
            'services' => 'required|array|min:1',
            'services.*.service_id' => 'required|exists:services,id',
            'services.*.quantity' => 'required|integer|min:1|max:1000',
            'services.*.unit_price' => 'required|numeric|min:0|max:999999.99'
        ];
    }

    public function messages()
    {
        return [
            'customer_id.required' => 'Please select a customer.',
            'services.required' => 'At least one service must be added.',
            'services.min' => 'At least one service must be added.',
            'delivery_date.after_or_equal' => 'Delivery date cannot be before order date.',
        ];
    }
}