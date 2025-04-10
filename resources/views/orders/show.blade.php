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

                        <!-- Shipping Status Banner -->
                        <div class="mb-4 p-3 rounded-lg {{ $order->shipping_status === 'pending' ? 'bg-yellow-50 border border-yellow-200' : ($order->shipping_status === 'shipped' ? 'bg-blue-50 border border-blue-200' : 'bg-green-50 border border-green-200') }}">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="mr-3 flex-shrink-0">
                                        @if($order->shipping_status === 'pending')
                                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                            </svg>
                                        @elseif($order->shipping_status === 'shipped')
                                            <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                                                <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1v-5h2.038A2.968 2.968 0 0115 12.995V13a1 1 0 001-1v-2a1 1 0 00-1-1h-3.034A2.968 2.968 0 0112 11.995V12H9V8.414l.293.293a1 1 0 001.414-1.414l-2-2a1 1 0 00-1.414 0l-2 2a1 1 0 001.414 1.414l.293-.293V12H3V5a1 1 0 00-1-1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V4a1 1 0 00-1-1H3z" />
                                            </svg>
                                        @else
                                            <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-medium {{ $order->shipping_status === 'pending' ? 'text-yellow-800' : ($order->shipping_status === 'shipped' ? 'text-blue-800' : 'text-green-800') }}">
                                            @if($order->shipping_status === 'pending')
                                                Order Processing
                                            @elseif($order->shipping_status === 'shipped')
                                                Order Shipped
                                            @else
                                                Order Delivered
                                            @endif
                                        </p>
                                        <p class="text-sm {{ $order->shipping_status === 'pending' ? 'text-yellow-600' : ($order->shipping_status === 'shipped' ? 'text-blue-600' : 'text-green-600') }}">
                                            @if($order->shipping_status === 'pending')
                                                Your order is being processed and will be shipped soon.
                                            @elseif($order->shipping_status === 'shipped')
                                                Your order is on its way to you!
                                            @else
                                                Your order has been delivered successfully.
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <span>{!! $order->shipping_status_badge !!}</span>
                            </div>
                        </div>

                        <!-- Order Tracking Progress -->
                        <div class="mb-6">
                            <div class="relative">
                                <!-- Progress Bar -->
                                <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-gray-200">
                                    <div class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center
                                        {{ $order->shipping_status === 'pending' ? 'bg-yellow-500 w-1/3' :
                                           ($order->shipping_status === 'shipped' ? 'bg-blue-500 w-2/3' : 'bg-green-500 w-full') }}"></div>
                                </div>

                                <!-- Progress Steps -->
                                <div class="flex justify-between">
                                    <!-- Step 1: Processing -->
                                    <div class="text-center">
                                        <div class="w-8 h-8 mx-auto rounded-full flex items-center justify-center
                                            {{ $order->shipping_status !== 'pending' ? 'bg-green-500' : 'bg-yellow-500' }}">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                        <span class="block text-xs font-medium mt-1">Processing</span>
                                        @if($order->created_at)
                                            <span class="block text-xs text-gray-500">{{ $order->created_at->format('M d') }}</span>
                                        @endif
                                    </div>

                                    <!-- Step 2: Shipped -->
                                    <div class="text-center">
                                        <div class="w-8 h-8 mx-auto rounded-full flex items-center justify-center
                                            {{ $order->shipping_status === 'pending' ? 'bg-gray-300' :
                                               ($order->shipping_status !== 'pending' ? 'bg-blue-500' : '') }}">
                                            @if($order->shipping_status !== 'pending')
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            @else
                                                <span class="text-white text-sm">2</span>
                                            @endif
                                        </div>
                                        <span class="block text-xs font-medium mt-1">Shipped</span>
                                        @if($order->shipped_at)
                                            <span class="block text-xs text-gray-500">{{ $order->shipped_at->format('M d') }}</span>
                                        @endif
                                    </div>

                                    <!-- Step 3: Delivered -->
                                    <div class="text-center">
                                        <div class="w-8 h-8 mx-auto rounded-full flex items-center justify-center
                                            {{ $order->shipping_status === 'delivered' ? 'bg-green-500' : 'bg-gray-300' }}">
                                            @if($order->shipping_status === 'delivered')
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            @else
                                                <span class="text-white text-sm">3</span>
                                            @endif
                                        </div>
                                        <span class="block text-xs font-medium mt-1">Delivered</span>
                                        @if($order->delivered_at)
                                            <span class="block text-xs text-gray-500">{{ $order->delivered_at->format('M d') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            @if($order->estimated_delivery_date)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Estimated Delivery:</span>
                                <span class="font-medium">{{ $order->estimated_delivery_date->format('M d, Y') }}</span>
                            </div>
                            @endif
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

                            <div class="border-t border-gray-200 pt-2 mt-2">
                                <h3 class="text-sm font-medium text-gray-700 mb-2">Recipient Information</h3>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Name:</span>
                                    <span class="font-medium">{{ $order->recipient_name }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Phone:</span>
                                    <span class="font-medium">{{ $order->recipient_phone }}</span>
                                </div>
                            </div>

                            <div class="border-t border-gray-200 pt-2 mt-2">
                                <h3 class="text-sm font-medium text-gray-700 mb-2">Shipping Address</h3>
                                <div class="text-sm text-gray-600">
                                    <p>{{ $order->shipping_address }}</p>
                                </div>
                            </div>

                            @if($order->shipping_notes)
                            <div class="border-t border-gray-200 pt-2 mt-2">
                                <h3 class="text-sm font-medium text-gray-700 mb-2">Delivery Instructions</h3>
                                <div class="text-sm text-gray-600">
                                    <p>{{ $order->shipping_notes }}</p>
                                </div>
                            </div>
                            @endif

                            @if($order->tracking_number)
                            <div class="border-t border-gray-200 pt-2 mt-2">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Tracking Number:</span>
                                    <span class="font-medium">{{ $order->tracking_number }}</span>
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- Order Received Button -->
                        @if($order->shipping_status === 'shipped' && !$order->delivered_at)
                        <div class="mt-6">
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-blue-800">Action Required</h3>
                                        <div class="mt-2 text-sm text-blue-700">
                                            <p>Please confirm when you have received your order to complete the delivery process.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <form action="{{ route('orders.mark-delivered', $order) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
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
