@component('mail::message')
# Order Confirmation

Dear {{ $customer->name }},

Thank you for your order! We have successfully received your order and it is being processed.

## Order Details

**Order ID:** #{{ $order->id }}  
**Order Date:** {{ \Carbon\Carbon::parse($order->order_date)->format('F d, Y') }}  
**Delivery Date:** {{ \Carbon\Carbon::parse($order->delivery_date)->format('F d, Y') }}  
**Status:** {{ ucfirst($order->status) }}

## Ordered Services

@component('mail::table')
| Service | Quantity | Unit Price | Subtotal |
|:--------|:--------:|:----------:|---------:|
@foreach($orderItems as $item)
| {{ $item->service->name }} | {{ $item->quantity }} | ${{ number_format($item->unit_price, 2) }} | ${{ number_format($item->subtotal, 2) }} |
@endforeach
@endcomponent

**Total Amount:** ${{ number_format($order->total_amount, 2) }}

@if($order->notes)
## Additional Notes
{{ $order->notes }}
@endif

We will keep you updated on the progress of your order. If you have any questions, please don't hesitate to contact us.

@component('mail::button', ['url' => config('app.url')])
View Your Orders
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent