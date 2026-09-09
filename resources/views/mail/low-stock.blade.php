@component('mail::message')
# Low Stock Alert

Hello {{ $notifiable->name }},

Your product "{{ $product->name }}" is running low on stock.

**Current stock:** {{ $product->stock }}
**Low stock threshold:** {{ $product->low_stock_threshold }}
**SKU:** {{ $product->sku }}

[Go to Vendor Dashboard]({{ url('/vendor') }})

Please restock this product to avoid missed sales.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
