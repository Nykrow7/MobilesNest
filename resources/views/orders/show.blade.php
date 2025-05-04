@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-primary-100">
            <div class="p-6 bg-white">
                <div class="flex justify-between items-center mb-6 border-b border-primary-100 pb-4">
                    <h1 class="text-2xl font-semibold text-primary-900">Order #{{ $order->order_number }}</h1>
                    <a href="{{ route('orders.index') }}" class="bg-white border border-primary-200 hover:bg-primary-50 text-primary-800 font-bold py-2 px-4 rounded-lg transition-colors duration-150 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to Orders
                    </a>
                </div>

                @if(session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg relative mb-4 flex items-center" role="alert">
                        <svg class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg relative mb-4 flex items-center" role="alert">
                        <svg class="h-5 w-5 text-red-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                <!-- Order Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="bg-primary-50 p-5 rounded-lg border border-primary-100">
                        <h2 class="text-lg font-medium mb-4 text-primary-900 border-b border-primary-100 pb-2 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            Order Information
                        </h2>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center py-2 border-b border-primary-100">
                                <span class="text-primary-700">Order Number:</span>
                                <span class="font-medium text-primary-900">{{ $order->order_number }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-primary-100">
                                <span class="text-primary-700">Date:</span>
                                <span class="font-medium text-primary-900">{{ $order->created_at->format('M d, Y h:i A') }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-primary-100">
                                <span class="text-primary-700">Status:</span>
                                <span>{!! $order->status_badge !!}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-primary-100">
                                <span class="text-primary-700">Payment Method:</span>
                                <span class="font-medium text-primary-900">{{ ucfirst($order->payment_method) }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2">
                                <span class="text-primary-700">Payment Status:</span>
                                <span>{!! $order->payment_status_badge !!}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-primary-50 p-5 rounded-lg border border-primary-100">
                        <h2 class="text-lg font-medium mb-4 text-primary-900 border-b border-primary-100 pb-2 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                            </svg>
                            Shipping Information
                        </h2>

                        <!-- Shipping Status Banner -->
                        <div class="mb-4 p-4 rounded-lg {{ $order->shipping_status === 'pending' ? 'bg-yellow-50 border border-yellow-200' : ($order->shipping_status === 'shipped' ? 'bg-blue-50 border border-blue-200' : 'bg-green-50 border border-green-200') }}">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="mr-3 flex-shrink-0">
                                        @if($order->shipping_status === 'pending')
                                            <svg class="h-6 w-6 text-yellow-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                            </svg>
                                        @elseif($order->shipping_status === 'shipped')
                                            <svg class="h-6 w-6 text-blue-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                                                <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1v-5h2.038A2.968 2.968 0 0115 12.995V13a1 1 0 001-1v-2a1 1 0 00-1-1h-3.034A2.968 2.968 0 0112 11.995V12H9V8.414l.293.293a1 1 0 001.414-1.414l-2-2a1 1 0 00-1.414 0l-2 2a1 1 0 001.414 1.414l.293-.293V12H3V5a1 1 0 00-1-1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V4a1 1 0 00-1-1H3z" />
                                            </svg>
                                        @else
                                            <svg class="h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
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
                                <div class="overflow-hidden h-3 mb-5 text-xs flex rounded-full bg-primary-100">
                                    <div class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center rounded-full
                                        {{ $order->shipping_status === 'pending' ? 'bg-yellow-500 w-1/3' :
                                           ($order->shipping_status === 'shipped' ? 'bg-blue-500 w-2/3' : 'bg-green-500 w-full') }}"></div>
                                </div>

                                <!-- Progress Steps -->
                                <div class="flex justify-between">
                                    <!-- Step 1: Processing -->
                                    <div class="text-center">
                                        <div class="w-10 h-10 mx-auto rounded-full flex items-center justify-center shadow-sm
                                            {{ $order->shipping_status !== 'pending' ? 'bg-green-500' : 'bg-yellow-500' }}">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                        <span class="block text-xs font-medium mt-2 text-primary-800">Processing</span>
                                        @if($order->created_at)
                                            <span class="block text-xs text-primary-600">{{ $order->created_at->format('M d') }}</span>
                                        @endif
                                    </div>

                                    <!-- Step 2: Shipped -->
                                    <div class="text-center">
                                        <div class="w-10 h-10 mx-auto rounded-full flex items-center justify-center shadow-sm
                                            {{ $order->shipping_status === 'pending' ? 'bg-primary-200' :
                                               ($order->shipping_status !== 'pending' ? 'bg-blue-500' : '') }}">
                                            @if($order->shipping_status !== 'pending')
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            @else
                                                <span class="text-white text-sm">2</span>
                                            @endif
                                        </div>
                                        <span class="block text-xs font-medium mt-2 text-primary-800">Shipped</span>
                                        @if($order->shipped_at)
                                            <span class="block text-xs text-primary-600">{{ $order->shipped_at->format('M d') }}</span>
                                        @endif
                                    </div>

                                    <!-- Step 3: Delivered -->
                                    <div class="text-center">
                                        <div class="w-10 h-10 mx-auto rounded-full flex items-center justify-center shadow-sm
                                            {{ $order->shipping_status === 'delivered' ? 'bg-green-500' : 'bg-primary-200' }}">
                                            @if($order->shipping_status === 'delivered')
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            @else
                                                <span class="text-white text-sm">3</span>
                                            @endif
                                        </div>
                                        <span class="block text-xs font-medium mt-2 text-primary-800">Delivered</span>
                                        @if($order->delivered_at)
                                            <span class="block text-xs text-primary-600">{{ $order->delivered_at->format('M d') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-3">
                            @if($order->estimated_delivery_date)
                            <div class="flex justify-between items-center py-2 border-b border-primary-100">
                                <span class="text-primary-700">Estimated Delivery:</span>
                                <span class="font-medium text-primary-900">{{ $order->estimated_delivery_date->format('M d, Y') }}</span>
                            </div>
                            @endif
                            @if($order->shipped_at)
                            <div class="flex justify-between items-center py-2 border-b border-primary-100">
                                <span class="text-primary-700">Shipped Date:</span>
                                <span class="font-medium text-primary-900">{{ $order->shipped_at->format('M d, Y') }}</span>
                            </div>
                            @endif
                            @if($order->delivered_at)
                            <div class="flex justify-between items-center py-2 border-b border-primary-100">
                                <span class="text-primary-700">Delivered Date:</span>
                                <span class="font-medium text-primary-900">{{ $order->delivered_at->format('M d, Y') }}</span>
                            </div>
                            @endif

                            <div class="pt-2 mt-2">
                                <h3 class="text-sm font-medium text-primary-800 mb-2 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-primary-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Recipient Information
                                </h3>
                                <div class="flex justify-between items-center py-2 border-b border-primary-100">
                                    <span class="text-primary-700">Name:</span>
                                    <span class="font-medium text-primary-900">{{ $order->recipient_name }}</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-primary-100">
                                    <span class="text-primary-700">Phone:</span>
                                    <span class="font-medium text-primary-900">{{ $order->recipient_phone }}</span>
                                </div>
                            </div>

                            <div class="pt-2 mt-2">
                                <h3 class="text-sm font-medium text-primary-800 mb-2 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-primary-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    Shipping Address
                                </h3>
                                <div class="text-sm text-primary-800 bg-white p-3 rounded-md border border-primary-100">
                                    <p>{{ $order->shipping_address }}</p>
                                </div>
                            </div>

                            @if($order->shipping_notes)
                            <div class="pt-2 mt-2">
                                <h3 class="text-sm font-medium text-primary-800 mb-2 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-primary-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    Delivery Instructions
                                </h3>
                                <div class="text-sm text-primary-800 bg-white p-3 rounded-md border border-primary-100">
                                    <p>{{ $order->shipping_notes }}</p>
                                </div>
                            </div>
                            @endif

                            @if($order->tracking_number)
                            <div class="pt-2 mt-2">
                                <div class="flex justify-between items-center py-2 border-b border-primary-100">
                                    <span class="text-primary-700 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                        Tracking Number:
                                    </span>
                                    <span class="font-medium text-primary-900">{{ $order->tracking_number }}</span>
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
                                        <svg class="h-6 w-6 text-blue-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
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
                                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-lg flex items-center justify-center transition-colors duration-150 shadow-sm">
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
                <h2 class="text-lg font-medium mb-4 text-primary-900 border-b border-primary-100 pb-2 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    Order Items
                </h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-primary-100 rounded-lg overflow-hidden">
                        <thead>
                            <tr>
                                <th class="py-3 px-4 border-b border-primary-100 bg-primary-50 text-left text-xs leading-4 font-medium text-primary-700 uppercase tracking-wider">Product</th>
                                <th class="py-3 px-4 border-b border-primary-100 bg-primary-50 text-left text-xs leading-4 font-medium text-primary-700 uppercase tracking-wider">Price</th>
                                <th class="py-3 px-4 border-b border-primary-100 bg-primary-50 text-left text-xs leading-4 font-medium text-primary-700 uppercase tracking-wider">Quantity</th>
                                <th class="py-3 px-4 border-b border-primary-100 bg-primary-50 text-left text-xs leading-4 font-medium text-primary-700 uppercase tracking-wider">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr class="hover:bg-primary-50 transition-colors duration-150">
                                <td class="py-4 px-4 border-b border-primary-100">
                                    <div class="flex items-center">
                                        @if($item->product->primaryImage)
                                            <img class="h-16 w-16 mr-4 object-cover rounded-lg border border-primary-100" src="{{ asset('storage/' . $item->product->primaryImage->image_path) }}" alt="{{ $item->product->name }}">
                                        @else
                                            <div class="h-16 w-16 mr-4 bg-primary-50 rounded-lg border border-primary-100 flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="text-sm leading-5 font-medium text-primary-900">{{ $item->product->name }}</div>
                                            <div class="text-sm leading-5 text-primary-700">{{ $item->product->brand }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4 border-b border-primary-100 text-sm leading-5 text-primary-800">
                                    {{ $item->formatted_unit_price }}
                                </td>
                                <td class="py-4 px-4 border-b border-primary-100 text-sm leading-5 text-primary-800">
                                    {{ $item->quantity }}
                                </td>
                                <td class="py-4 px-4 border-b border-primary-100 text-sm leading-5 font-medium text-primary-900">
                                    {{ $item->formatted_subtotal }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-primary-50">
                            <tr>
                                <td colspan="3" class="py-3 px-4 text-right font-medium text-primary-800">Subtotal:</td>
                                <td class="py-3 px-4 text-primary-800">{{ $order->formatted_total_amount }}</td>
                            </tr>
                            @if($order->discount_amount > 0)
                            <tr>
                                <td colspan="3" class="py-3 px-4 text-right font-medium text-primary-800">Discount:</td>
                                <td class="py-3 px-4 text-primary-800">{{ $order->formatted_discount_amount }}</td>
                            </tr>
                            @endif
                            <tr class="bg-primary-100">
                                <td colspan="3" class="py-4 px-4 text-right font-medium text-primary-900">Total:</td>
                                <td class="py-4 px-4 font-bold text-primary-900">{{ $order->formatted_final_amount }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Order Actions -->
                <div class="mt-6 flex justify-end">
                    @if($order->status === 'pending')
                    <form action="{{ route('orders.cancel', $order) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-150 flex items-center shadow-sm" onclick="return confirm('Are you sure you want to cancel this order?')">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
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
