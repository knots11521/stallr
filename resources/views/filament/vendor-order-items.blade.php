@php
    $items = $field->getRecord()->items;
@endphp

@if($items->isNotEmpty())
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b">
                    <th class="text-left py-2">Product</th>
                    <th class="text-right py-2">Qty</th>
                    <th class="text-right py-2">Unit Price</th>
                    <th class="text-right py-2">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                    <tr class="border-b">
                        <td class="py-2">{{ $item->product_name }}</td>
                        <td class="text-right py-2">{{ $item->quantity }}</td>
                        <td class="text-right py-2">{{ number_format($item->unit_price, 2) }} PHP</td>
                        <td class="text-right py-2">{{ number_format($item->subtotal, 2) }} PHP</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <span class="text-gray-500">No items found.</span>
@endif
