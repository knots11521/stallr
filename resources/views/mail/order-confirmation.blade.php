@component('mail::message')
# Order Confirmation

Hello {{ $notifiable->name }},

Thank you for your order. Your order has been placed successfully.

**Order Number:** {{ $order->order_number }}
**Total:** ₱{{ number_format((float) $order->total, 2) }}
**Date:** {{ $order->created_at->format('M d, Y h:i A') }}

@component('mail::panel')
@foreach ($order->vendorOrders as $vendorOrder)
## {{ $vendorOrder->vendor->store_name ?? 'Store' }}

@foreach ($vendorOrder->items as $item)
- **{{ $item->product_name }}** — Qty: {{ $item->quantity }} × ₱{{ number_format((float) $item->unit_price, 2) }} = ₱{{ number_format((float) $item->subtotal, 2) }}
@endforeach

**Store Total:** ₱{{ number_format((float) $vendorOrder->total, 2) }}

@endcomponent
@endforeach
@endcomponent

You will receive updates as your order is processed.

[View Order]({{ url('/orders/' . $order->id) }})

Thanks,<br>
{{ config('app.name') }}
@endcomponent
