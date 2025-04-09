@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-semibold">Order #{{ $order->order_number }}</h1>
                    <a href="{{ route('orders.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded">
                        Back to Orders
                    </a>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                <!-- Order Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h2 class="text-lg font-medium mb-4">Order Information</h2>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Order Number:</span>
                                <span class="font-medium">{{ $order->order_number }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Date:</span>
                                <span class="font-medium">{{ $order->created_at->format('M d, Y h:i A') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Status:</span>
                                <span>{!! $order->status_badge !!}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Payment Method:</span>
                                <span class="font-medium">{{ ucfirst($order->payment_method) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Payment Status:</span>
                                <span>{!! $order->payment_status_badge !!}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h2 class="text-lg font-medium mb-4">Shipping Information</h2>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Shipping Status:</span>
                                <span>{!! $order->shipping_status_badge !!}</span>
                            </div>
                            @if($order->shipped_at)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Shipped Date:</span>
                                <span class="font-medium">{{ $order->shipped_at->format('M d, Y') }}</span>
                            </div>
                            @endif
                            @if($order->delivered_at)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Delivered Date:</span>
                                <span class="font-medium">{{ $order->delivered_at->format('M d, Y') }}</span>
                            </div>
                            @endif
                            <div class="flex justify-between">
                                <span class="text-gray-600">Shipping Address:</span>
                                <span class="font-medium">{{ $order->shipping_address }}</span>
                            </div>
                            @if($order->tracking_number)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tracking Number:</span>
                                <span class="font-medium">{{ $order->tracking_number }}</span>
                            </div>
                            @endif
                        </div>

                        <!-- Order Received Button -->
                        @if($order->shipping_status === 'shipped' && !$order->delivered_at)
                        <div class="mt-4">
                            <form action="{{ route('orders.mark-delivered', $order) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    Confirm Order Received
                                </button>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Order Items -->
                <h2 class="text-lg font-medium mb-4">Order Items</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td class="py-4 px-4 border-b border-gray-200">
                                    <div class="flex items-center">
                                        @if($item->product->primaryImage)
                                            <img class="h-12 w-12 mr-4 object-cover rounded" src="{{ asset('storage/' . $item->product->primaryImage->image_path) }}" alt="{{ $item->product->name }}">
                                        @else
                                            <div class="h-12 w-12 mr-4 bg-gray-200 rounded flex items-center justify-center">
                                                <span class="text-gray-500 text-xs">No image</span>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="text-sm leading-5 font-medium text-gray-900">{{ $item->product->name }}</div>
                                            <div class="text-sm leading-5 text-gray-500">{{ $item->product->brand }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4 border-b border-gray-200 text-sm leading-5">
                                    {{ $item->formatted_unit_price }}
                                </td>
                                <td class="py-4 px-4 border-b border-gray-200 text-sm leading-5">
                                    {{ $item->quantity }}
                                </td>
                                <td class="py-4 px-4 border-b border-gray-200 text-sm leading-5">
                                    {{ $item->formatted_subtotal }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="py-4 px-4 text-right font-medium">Subtotal:</td>
                                <td class="py-4 px-4">{{ $order->formatted_total_amount }}</td>
                            </tr>
                            @if($order->discount_amount > 0)
                            <tr>
                                <td colspan="3" class="py-4 px-4 text-right font-medium">Discount:</td>
                                <td class="py-4 px-4">{{ $order->formatted_discount_amount }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td colspan="3" class="py-4 px-4 text-right font-medium">Total:</td>
                                <td class="py-4 px-4 font-bold">{{ $order->formatted_final_amount }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Order Actions -->
                <div class="mt-6 flex justify-end">
                    @if($order->status === 'pending')
                    <form action="{{ route('orders.cancel', $order) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Are you sure you want to cancel this order?')">
                            Cancel Order
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
