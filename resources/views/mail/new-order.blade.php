@component('mail::message')
# New Order Received

Hello {{ $notifiable->name }},

You have received a new order.

**Order Number:** {{ $order->order_number }}
**Customer:** {{ $order->user->name ?? 'N/A' }}
**Date:** {{ $order->created_at->format('M d, Y h:i A') }}

@component('mail::panel')
@foreach ($vendorOrder->items as $item)
- **{{ $item->product_name }}** — Qty: {{ $item->quantity }} × ₱{{ number_format((float) $item->unit_price, 2) }} = ₱{{ number_format((float) $item->subtotal, 2) }}
@endforeach

**Store Total:** ₱{{ number_format((float) $vendorOrder->total, 2) }}
@endcomponent

[Go to Vendor Dashboard]({{ url('/vendor') }})

Please log in to your vendor dashboard to manage this order.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
