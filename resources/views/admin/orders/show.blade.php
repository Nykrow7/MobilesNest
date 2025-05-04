@extends('layouts.admin')

@section('title', 'Order Details')

@section('content')
<div class="container-fluid px-4">
    <!-- Page Header -->
    <div class="flex justify-between items-center mt-6 mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-black">Order Details</h1>
            <nav class="flex mt-2" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-indigo-600">
                            <i class="fas fa-home mr-2"></i>Dashboard
                        </a>
                    </li>
                    <li class="inline-flex items-center">
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs"></i>
                            <a href="{{ route('admin.orders.index') }}" class="text-gray-700 hover:text-indigo-600">
                                Orders
                            </a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs"></i>
                            <span class="text-gray-500">Order #{{ $order->order_number }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.orders.edit', $order) }}" class="inline-flex items-center px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 border border-transparent rounded-md shadow-sm text-sm font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <i class="fas fa-edit mr-1.5 text-sm"></i> Edit Order
            </a>
            <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center px-3 py-1.5 bg-white border border-gray-300 rounded-md shadow-sm text-sm font-medium text-black hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <i class="fas fa-arrow-left mr-1.5 text-sm"></i> Back to Orders
            </a>
        </div>
    </div>

    <!-- Order Summary -->
    <div class="bg-white rounded-md shadow-sm border border-gray-200 overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-medium text-black flex items-center">
                <i class="fas fa-info-circle mr-2 text-indigo-600"></i>
                Order Summary
            </h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-indigo-50 rounded-lg p-4">
                    <div class="text-sm text-indigo-600 mb-1">Order Number</div>
                    <div class="text-xl font-semibold text-black">{{ $order->order_number }}</div>
                </div>
                <div class="bg-green-50 rounded-lg p-4">
                    <div class="text-sm text-green-600 mb-1">Total Amount</div>
                    <div class="text-xl font-semibold text-black">{{ $order->formatted_total_amount }}</div>
                </div>
                <div class="bg-blue-50 rounded-lg p-4">
                    <div class="text-sm text-blue-600 mb-1">Status</div>
                    <div class="text-xl font-semibold">{!! $order->status_badge !!}</div>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="text-sm text-gray-600 mb-1">Date</div>
                    <div class="text-xl font-semibold text-black">{{ $order->created_at->format('M d, Y') }}</div>
                    <div class="text-sm text-gray-500">{{ $order->created_at->format('h:i A') }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Details and Shipping Information -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Order Information -->
        <div class="bg-white rounded-md shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-black flex items-center">
                    <i class="fas fa-file-invoice mr-2 text-indigo-600"></i>
                    Order Information
                </h2>
            </div>
            <div class="p-6">
                <div class="divide-y divide-gray-200">
                    <div class="py-3 flex flex-col sm:flex-row">
                        <dt class="text-sm font-medium text-gray-500 sm:w-40 sm:flex-shrink-0">Order Number</dt>
                        <dd class="mt-1 text-sm font-medium text-black sm:mt-0 sm:ml-6">{{ $order->order_number }}</dd>
                    </div>
                    <div class="py-3 flex flex-col sm:flex-row">
                        <dt class="text-sm font-medium text-gray-500 sm:w-40 sm:flex-shrink-0">Status</dt>
                        <dd class="mt-1 text-sm sm:mt-0 sm:ml-6">{!! $order->status_badge !!}</dd>
                    </div>
                    <div class="py-3 flex flex-col sm:flex-row">
                        <dt class="text-sm font-medium text-gray-500 sm:w-40 sm:flex-shrink-0">Payment Method</dt>
                        <dd class="mt-1 text-sm text-black sm:mt-0 sm:ml-6">
                            @if($order->payment_method == 'credit_card')
                                <span class="inline-flex items-center">
                                    <i class="far fa-credit-card text-blue-500 mr-2"></i>
                                    Credit Card
                                </span>
                            @elseif($order->payment_method == 'paypal')
                                <span class="inline-flex items-center">
                                    <i class="fab fa-paypal text-blue-600 mr-2"></i>
                                    PayPal
                                </span>
                            @elseif($order->payment_method == 'bank_transfer')
                                <span class="inline-flex items-center">
                                    <i class="fas fa-university text-gray-600 mr-2"></i>
                                    Bank Transfer
                                </span>
                            @else
                                {{ ucfirst($order->payment_method) }}
                            @endif
                        </dd>
                    </div>
                    <div class="py-3 flex flex-col sm:flex-row">
                        <dt class="text-sm font-medium text-gray-500 sm:w-40 sm:flex-shrink-0">Payment Status</dt>
                        <dd class="mt-1 text-sm sm:mt-0 sm:ml-6">{!! $order->payment_status_badge !!}</dd>
                    </div>
                    <div class="py-3 flex flex-col sm:flex-row">
                        <dt class="text-sm font-medium text-gray-500 sm:w-40 sm:flex-shrink-0">Total Amount</dt>
                        <dd class="mt-1 text-sm font-medium text-black sm:mt-0 sm:ml-6">{{ $order->formatted_total_amount }}</dd>
                    </div>
                    <div class="py-3 flex flex-col sm:flex-row">
                        <dt class="text-sm font-medium text-gray-500 sm:w-40 sm:flex-shrink-0">Order Date</dt>
                        <dd class="mt-1 text-sm text-black sm:mt-0 sm:ml-6">{{ $order->created_at->format('F d, Y h:i A') }}</dd>
                    </div>
                </div>
            </div>
        </div>

        <!-- Shipping Information -->
        <div class="bg-white rounded-md shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-black flex items-center">
                    <i class="fas fa-shipping-fast mr-2 text-indigo-600"></i>
                    Shipping Information
                </h2>
            </div>
            <div class="p-6">
                <div class="divide-y divide-gray-200">
                    <div class="py-3 flex flex-col sm:flex-row">
                        <dt class="text-sm font-medium text-gray-500 sm:w-40 sm:flex-shrink-0">Shipping Status</dt>
                        <dd class="mt-1 text-sm sm:mt-0 sm:ml-6">{!! $order->shipping_status_badge !!}</dd>
                    </div>
                    @if($order->tracking_number)
                    <div class="py-3 flex flex-col sm:flex-row">
                        <dt class="text-sm font-medium text-gray-500 sm:w-40 sm:flex-shrink-0">Tracking Number</dt>
                        <dd class="mt-1 text-sm font-medium text-indigo-600 sm:mt-0 sm:ml-6">{{ $order->tracking_number }}</dd>
                    </div>
                    @endif
                    @if($order->shipped_at)
                    <div class="py-3 flex flex-col sm:flex-row">
                        <dt class="text-sm font-medium text-gray-500 sm:w-40 sm:flex-shrink-0">Shipped Date</dt>
                        <dd class="mt-1 text-sm text-black sm:mt-0 sm:ml-6">{{ $order->shipped_at->format('F d, Y') }}</dd>
                    </div>
                    @endif
                    @if($order->delivered_at)
                    <div class="py-3 flex flex-col sm:flex-row">
                        <dt class="text-sm font-medium text-gray-500 sm:w-40 sm:flex-shrink-0">Delivered Date</dt>
                        <dd class="mt-1 text-sm text-black sm:mt-0 sm:ml-6">{{ $order->delivered_at->format('F d, Y') }}</dd>
                    </div>
                    @endif
                </div>

                <div class="mt-6">
                    <h3 class="text-sm font-medium text-black mb-3">Shipping Address</h3>
                    <div class="bg-gray-50 rounded-md p-4">
                        <p class="text-sm text-black whitespace-pre-line">
                            {{ $order->shipping_address }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Customer Information and Order Notes -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Customer Information -->
        <div class="bg-white rounded-md shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-black flex items-center">
                    <i class="fas fa-user mr-2 text-indigo-600"></i>
                    Customer Information
                </h2>
            </div>
            <div class="p-6">
                <div class="flex items-center mb-6">
                    <div class="bg-gray-200 rounded-full w-12 h-12 flex items-center justify-center mr-4 flex-shrink-0">
                        <i class="fas fa-user text-gray-500 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-medium text-black mb-1">
                            <a href="{{ route('admin.users.show', $order->user) }}" class="text-indigo-600 hover:text-indigo-800">
                                {{ $order->user->name }}
                            </a>
                        </h3>
                        <p class="text-gray-500">{{ $order->user->email }}</p>
                    </div>
                </div>

                <div class="divide-y divide-gray-200">
                    <div class="py-3 flex flex-col sm:flex-row">
                        <dt class="text-sm font-medium text-gray-500 sm:w-40 sm:flex-shrink-0">Customer ID</dt>
                        <dd class="mt-1 text-sm text-black sm:mt-0 sm:ml-6">#{{ $order->user->id }}</dd>
                    </div>
                    <div class="py-3 flex flex-col sm:flex-row">
                        <dt class="text-sm font-medium text-gray-500 sm:w-40 sm:flex-shrink-0">Email</dt>
                        <dd class="mt-1 text-sm text-black sm:mt-0 sm:ml-6">{{ $order->user->email }}</dd>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Notes -->
        <div class="bg-white rounded-md shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-black flex items-center">
                    <i class="fas fa-sticky-note mr-2 text-indigo-600"></i>
                    Order Notes
                </h2>
            </div>
            <div class="p-6">
                @if($order->notes)
                    <div class="bg-gray-50 rounded-md p-4">
                        <p class="text-sm text-black whitespace-pre-line">{{ $order->notes }}</p>
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-gray-100">
                            <i class="fas fa-sticky-note text-gray-500 text-xl"></i>
                        </div>
                        <h3 class="mt-2 text-sm font-medium text-black">No notes</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            No additional notes are available for this order.
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Order Items -->
    <div class="bg-white rounded-md shadow-sm border border-gray-200 overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-medium text-black flex items-center">
                <i class="fas fa-shopping-basket mr-2 text-indigo-600"></i>
                Order Items
            </h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">Product</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">Price</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">Quantity</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-black uppercase tracking-wider">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($order->items as $item)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-12 w-12">
                                        @if($item->product->primaryImage)
                                        <img src="{{ asset('storage/' . $item->product->primaryImage->image_path) }}" alt="{{ $item->product->name }}" class="h-12 w-12 rounded-md object-cover">
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <a href="{{ route('admin.products.show', $item->product) }}" class="text-sm font-medium text-black hover:text-indigo-600">
                                            {{ $item->product->name }}
                                        </a>
                                        <div class="text-xs text-gray-500">SKU: {{ $item->product->sku ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-black">{{ $item->formatted_unit_price }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-black">{{ $item->quantity }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-black text-right font-medium">{{ $item->formatted_subtotal }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50">
                    <tr>
                        <th colspan="3" class="px-6 py-3 text-right text-sm font-medium text-black">Total:</th>
                        <td class="px-6 py-3 text-right text-sm font-bold text-black">{{ $order->formatted_total_amount }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

@section('scripts')
<script>
    $(document).ready(function() {
        // Initialize tooltips if any
        if (typeof $.fn.tooltip === 'function') {
            $('[data-bs-toggle="tooltip"]').tooltip();
        }
    });
</script>
@endsection

@endsection
