@extends('layouts.app')

@section('title', 'Order Successful')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="text-center mb-6">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-800">Order Successful!</h1>
            <p class="text-gray-600 mt-2">Thank you for your purchase. Your order has been received.</p>
        </div>

        <div class="border-t border-gray-200 pt-4 mb-6">
            <div class="flex justify-between items-center mb-2">
                <span class="text-gray-600">Order Number:</span>
                <span class="font-semibold">{{ $order->order_number }}</span>
            </div>
            <div class="flex justify-between items-center mb-2">
                <span class="text-gray-600">Date:</span>
                <span class="font-semibold">{{ $order->created_at->format('F d, Y') }}</span>
            </div>
            <div class="flex justify-between items-center mb-2">
                <span class="text-gray-600">Payment Method:</span>
                <span class="font-semibold">{{ ucfirst($order->payment_method) }}</span>
            </div>
            <div class="flex justify-between items-center mb-2">
                <span class="text-gray-600">Payment Status:</span>
                <span class="font-semibold">{!! $order->payment_status_badge !!}</span>
            </div>
            @if($order->transactions->isNotEmpty())
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Transaction ID:</span>
                    <span class="font-semibold">{{ $order->transactions->first()->transaction_number }}</span>
                </div>
            @endif
        </div>

        <h2 class="text-xl font-semibold mb-4">Order Details</h2>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                        <th class="px-4 py-3 bg-gray-50 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                        <th class="px-4 py-3 bg-gray-50 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                        <th class="px-4 py-3 bg-gray-50 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($order->items as $item)
                        <tr>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        @if($item->product && $item->product->primaryImage && $item->product->primaryImage->url)
                                        <img class="h-10 w-10 rounded-md object-cover" src="{{ $item->product->primaryImage->url }}" alt="{{ $item->product->name ?? 'Product Image' }}">
                                        @else
                                        <div class="h-10 w-10 rounded-md bg-gray-200 flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $item->product->name ?? 'Product Not Available' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-right text-sm text-gray-500">{{ $item->formatted_unit_price }}</td>
                            <td class="px-4 py-4 whitespace-nowrap text-right text-sm text-gray-500">{{ $item->quantity }}</td>
                            <td class="px-4 py-4 whitespace-nowrap text-right text-sm font-medium">{{ $item->formatted_subtotal }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="px-4 py-3 text-right text-sm font-medium">Subtotal:</td>
                        <td class="px-4 py-3 text-right text-sm font-medium">{{ $order->formatted_total_amount }}</td>
                    </tr>
                    @if($order->discount_amount > 0)
                        <tr>
                            <td colspan="3" class="px-4 py-3 text-right text-sm font-medium">Discount:</td>
                            <td class="px-4 py-3 text-right text-sm font-medium text-red-600">-{{ $order->formatted_discount_amount }}</td>
                        </tr>
                    @endif
                    <tr>
                        <td colspan="3" class="px-4 py-3 text-right text-base font-bold">Total:</td>
                        <td class="px-4 py-3 text-right text-base font-bold">{{ $order->formatted_final_amount }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="mt-8 text-center">
            <a href="{{ route('shop.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Continue Shopping
            </a>
        </div>
    </div>
</div>
@endsection