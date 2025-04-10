@extends('layouts.admin')

@section('title', 'Order Details')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Order Details</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-indigo-600 hover:text-indigo-800">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}" class="text-indigo-600 hover:text-indigo-800">Orders</a></li>
                <li class="breadcrumb-item active text-gray-500">Order #{{ $order->order_number }}</li>
            </ol>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.orders.edit', $order) }}" class="btn bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg shadow-sm transition duration-150 ease-in-out">
                <i class="fas fa-edit me-2"></i> Edit Order
            </a>
            <a href="{{ route('admin.orders.index') }}" class="btn bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium py-2 px-4 rounded-lg shadow-sm transition duration-150 ease-in-out">
                <i class="fas fa-arrow-left me-2"></i> Back to Orders
            </a>
        </div>
    </div>

    <!-- Order Summary Card -->
    <div class="card mb-4 shadow-sm border-0 overflow-hidden">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 text-indigo-700 font-medium"><i class="fas fa-info-circle me-2"></i>Order Summary</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <div class="p-4 bg-indigo-50 rounded-lg">
                        <div class="text-sm text-indigo-600 mb-1">Order Number</div>
                        <div class="text-xl font-semibold text-gray-800">{{ $order->order_number }}</div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="p-4 bg-green-50 rounded-lg">
                        <div class="text-sm text-green-600 mb-1">Total Amount</div>
                        <div class="text-xl font-semibold text-gray-800">{{ $order->formatted_total_amount }}</div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="p-4 bg-blue-50 rounded-lg">
                        <div class="text-sm text-blue-600 mb-1">Status</div>
                        <div class="text-xl font-semibold">{!! $order->status_badge !!}</div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <div class="text-sm text-gray-600 mb-1">Date</div>
                        <div class="text-xl font-semibold text-gray-800">{{ $order->created_at->format('M d, Y') }}</div>
                        <div class="text-sm text-gray-500">{{ $order->created_at->format('h:i A') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-4 shadow-sm border-0 overflow-hidden">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-gray-700 font-medium"><i class="fas fa-file-invoice me-2 text-indigo-600"></i>Order Details</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card shadow-sm border-0 h-100">
                                <div class="card-header bg-white py-3">
                                    <h5 class="mb-0 text-gray-700 font-medium">Order Information</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table">
                                        <tr>
                                            <th class="text-gray-600 font-medium border-0 py-3" style="width: 200px;">Order Number</th>
                                            <td class="border-0 py-3 font-medium">{{ $order->order_number }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-gray-600 font-medium border-0 py-3">Status</th>
                                            <td class="border-0 py-3">{!! $order->status_badge !!}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-gray-600 font-medium border-0 py-3">Payment Method</th>
                                            <td class="border-0 py-3">
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
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-gray-600 font-medium border-0 py-3">Payment Status</th>
                                            <td class="border-0 py-3">{!! $order->payment_status_badge !!}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-gray-600 font-medium border-0 py-3">Total Amount</th>
                                            <td class="border-0 py-3 font-medium">{{ $order->formatted_total_amount }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-gray-600 font-medium border-0 py-3">Order Date</th>
                                            <td class="border-0 py-3">{{ $order->created_at->format('F d, Y h:i A') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card shadow-sm border-0 h-100">
                                <div class="card-header bg-white py-3">
                                    <h5 class="mb-0 text-gray-700 font-medium">Shipping Information</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table">
                                        <tr>
                                            <th class="text-gray-600 font-medium border-0 py-3" style="width: 200px;">Shipping Status</th>
                                            <td class="border-0 py-3">{!! $order->shipping_status_badge !!}</td>
                                        </tr>
                                        @if($order->tracking_number)
                                        <tr>
                                            <th class="text-gray-600 font-medium border-0 py-3">Tracking Number</th>
                                            <td class="border-0 py-3">
                                                <span class="font-medium text-indigo-600">{{ $order->tracking_number }}</span>
                                            </td>
                                        </tr>
                                        @endif
                                        @if($order->shipped_at)
                                        <tr>
                                            <th class="text-gray-600 font-medium border-0 py-3">Shipped Date</th>
                                            <td class="border-0 py-3">{{ $order->shipped_at->format('F d, Y') }}</td>
                                        </tr>
                                        @endif
                                        @if($order->delivered_at)
                                        <tr>
                                            <th class="text-gray-600 font-medium border-0 py-3">Delivered Date</th>
                                            <td class="border-0 py-3">{{ $order->delivered_at->format('F d, Y') }}</td>
                                        </tr>
                                        @endif
                                    </table>

                                    <div class="mt-4">
                                        <h6 class="text-sm font-medium text-gray-700 mb-2">Shipping Address</h6>
                                        <div class="p-3 bg-gray-50 rounded-lg">
                                            <p class="text-gray-600 mb-0">
                                                {{ $order->shipping_address }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card shadow-sm border-0 h-100">
                                <div class="card-header bg-white py-3">
                                    <h5 class="mb-0 text-gray-700 font-medium"><i class="fas fa-user me-2 text-indigo-600"></i>Customer Information</h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-4">
                                        <div class="bg-gray-200 rounded-lg w-12 h-12 d-flex align-items-center justify-content-center me-3">
                                            <i class="fas fa-user text-gray-500 fs-4"></i>
                                        </div>
                                        <div>
                                            <h6 class="font-medium text-gray-800 mb-0">
                                                <a href="{{ route('admin.users.show', $order->user) }}" class="text-indigo-600 hover:text-indigo-800">
                                                    {{ $order->user->name }}
                                                </a>
                                            </h6>
                                            <p class="text-gray-500 mb-0">{{ $order->user->email }}</p>
                                        </div>
                                    </div>
                                    <table class="table">
                                        <tr>
                                            <th class="text-gray-600 font-medium border-0 py-3" style="width: 200px;">Customer ID</th>
                                            <td class="border-0 py-3">#{{ $order->user->id }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-gray-600 font-medium border-0 py-3">Email</th>
                                            <td class="border-0 py-3">{{ $order->user->email }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card shadow-sm border-0 h-100">
                                <div class="card-header bg-white py-3">
                                    <h5 class="mb-0 text-gray-700 font-medium"><i class="fas fa-sticky-note me-2 text-indigo-600"></i>Order Notes</h5>
                                </div>
                                <div class="card-body">
                                    @if($order->notes)
                                        <div class="p-4 bg-gray-50 rounded-lg">
                                            <p class="text-gray-600 mb-0">{{ $order->notes }}</p>
                                        </div>
                                    @else
                                        <div class="text-center py-4 text-gray-500">
                                            <i class="fas fa-sticky-note mb-2 text-2xl"></i>
                                            <p>No notes available for this order</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0 text-gray-700 font-medium"><i class="fas fa-shopping-basket me-2 text-indigo-600"></i>Order Items</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead class="bg-gray-50 text-gray-600 text-sm">
                                        <tr>
                                            <th class="py-3 px-4 font-medium">Product</th>
                                            <th class="py-3 px-4 font-medium">Price</th>
                                            <th class="py-3 px-4 font-medium">Quantity</th>
                                            <th class="py-3 px-4 font-medium text-right">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @foreach($order->items as $item)
                                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                                <td class="py-3 px-4">
                                                    <div class="d-flex align-items-center">
                                                        @if($item->product->primaryImage)
                                                        <img src="{{ asset('storage/' . $item->product->primaryImage->image_path) }}" alt="{{ $item->product->name }}" class="me-3 rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                                        @endif
                                                        <div>
                                                            <a href="{{ route('admin.products.show', $item->product) }}" class="text-gray-800 hover:text-indigo-600 font-medium">
                                                                {{ $item->product->name }}
                                                            </a>
                                                            <p class="text-gray-500 text-sm mb-0">SKU: {{ $item->product->sku ?? 'N/A' }}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="py-3 px-4 align-middle">{{ $item->formatted_unit_price }}</td>
                                                <td class="py-3 px-4 align-middle">{{ $item->quantity }}</td>
                                                <td class="py-3 px-4 align-middle text-right font-medium">{{ $item->formatted_subtotal }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="bg-gray-50">
                                        <tr>
                                            <th colspan="3" class="text-right py-3 px-4 font-medium text-gray-800">Total:</th>
                                            <td class="py-3 px-4 text-right font-bold text-gray-800">{{ $order->formatted_total_amount }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
