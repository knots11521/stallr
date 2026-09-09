@php
    $order = $field->getRecord();
    $vendorOrders = $order->vendorOrders ?? collect();
@endphp

@if($vendorOrders->isNotEmpty())
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b">
                    <th class="text-left py-2">Vendor</th>
                    <th class="text-center py-2">Status</th>
                    <th class="text-right py-2">Subtotal</th>
                    <th class="text-right py-2">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vendorOrders as $vendorOrder)
                    <tr class="border-b">
                        <td class="py-2">{{ $vendorOrder->vendor->store_name ?? 'N/A' }}</td>
                        <td class="text-center py-2">
                            <span class="px-2 py-1 rounded text-xs font-semibold
                                @if($vendorOrder->status === 'pending') bg-amber-100 text-amber-800
                                @elseif($vendorOrder->status === 'processing') bg-blue-100 text-blue-800
                                @elseif($vendorOrder->status === 'shipped') bg-purple-100 text-purple-800
                                @elseif($vendorOrder->status === 'delivered') bg-emerald-100 text-emerald-800
                                @elseif($vendorOrder->status === 'cancelled') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($vendorOrder->status) }}
                            </span>
                        </td>
                        <td class="text-right py-2">₱{{ number_format((float) $vendorOrder->subtotal, 2) }}</td>
                        <td class="text-right py-2">₱{{ number_format((float) $vendorOrder->total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <span class="text-gray-500">No vendor orders found.</span>
@endif
