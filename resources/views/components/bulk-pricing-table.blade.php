<div class="mt-4 bg-gray-50 p-4 rounded-lg">
    <h3 class="text-lg font-semibold mb-2">Bulk Pricing</h3>
    <p class="text-sm text-gray-600 mb-3">Buy more and save with our bulk pricing tiers!</p>
    
    @if($product->bulkPricingTiers->where('is_active', true)->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price Per Unit</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Discount</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Regular price row -->
                    <tr>
                        <td class="py-2 px-4 border-b border-gray-200 text-sm">1</td>
                        <td class="py-2 px-4 border-b border-gray-200 text-sm">${{ number_format($product->price, 2) }}</td>
                        <td class="py-2 px-4 border-b border-gray-200 text-sm">-</td>
                    </tr>
                    
                    <!-- Bulk pricing tiers -->
                    @foreach($product->bulkPricingTiers->where('is_active', true)->sortBy('min_quantity') as $tier)
                        <tr class="bg-green-50">
                            <td class="py-2 px-4 border-b border-gray-200 text-sm">
                                {{ $tier->min_quantity }}
                                @if($tier->max_quantity)
                                    - {{ $tier->max_quantity }}
                                @else
                                    +
                                @endif
                            </td>
                            <td class="py-2 px-4 border-b border-gray-200 text-sm font-medium text-green-700">
                                ${{ number_format($tier->price, 2) }}
                            </td>
                            <td class="py-2 px-4 border-b border-gray-200 text-sm text-green-700">
                                @php
                                    $savingsPercent = (($product->price - $tier->price) / $product->price) * 100;
                                @endphp
                                Save {{ number_format($savingsPercent, 0) }}%
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-sm text-gray-500">No bulk pricing available for this product.</p>
    @endif
</div>