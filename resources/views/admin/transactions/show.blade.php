@extends('layouts.admin')

@section('title', 'Transaction Details')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Transaction Details</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-indigo-600 hover:text-indigo-800">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.transactions.index') }}" class="text-indigo-600 hover:text-indigo-800">Transactions</a></li>
                <li class="breadcrumb-item active text-gray-500">{{ $transaction->transaction_number }}</li>
            </ol>
        </div>
        <div>
            <a href="{{ route('admin.transactions.index') }}" class="btn bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium py-2 px-4 rounded-lg shadow-sm transition duration-150 ease-in-out">
                <i class="fas fa-arrow-left me-2"></i> Back to Transactions
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <!-- Transaction Summary Card -->
            <div class="card mb-4 shadow-sm border-0 overflow-hidden">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 text-indigo-700 font-medium"><i class="fas fa-info-circle me-2"></i>Transaction Summary</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="p-4 bg-indigo-50 rounded-lg">
                                <div class="text-sm text-indigo-600 mb-1">Transaction Number</div>
                                <div class="text-xl font-semibold text-gray-800">{{ $transaction->transaction_number }}</div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="p-4 bg-green-50 rounded-lg">
                                <div class="text-sm text-green-600 mb-1">Amount</div>
                                <div class="text-xl font-semibold text-gray-800">{{ $transaction->formatted_amount }}</div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="p-4 bg-blue-50 rounded-lg">
                                <div class="text-sm text-blue-600 mb-1">Status</div>
                                <div class="text-xl font-semibold">{!! $transaction->status_badge !!}</div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="p-4 bg-gray-50 rounded-lg">
                                <div class="text-sm text-gray-600 mb-1">Date</div>
                                <div class="text-xl font-semibold text-gray-800">{{ $transaction->created_at->format('M d, Y') }}</div>
                                <div class="text-sm text-gray-500">{{ $transaction->created_at->format('h:i A') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transaction Details -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0 text-gray-700 font-medium">Transaction Details</h5>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <tr>
                                    <th class="text-gray-600 font-medium border-0 py-3" style="width: 200px;">Transaction Number</th>
                                    <td class="border-0 py-3">{{ $transaction->transaction_number }}</td>
                                </tr>
                                <tr>
                                    <th class="text-gray-600 font-medium border-0 py-3">Amount</th>
                                    <td class="border-0 py-3 font-medium">{{ $transaction->formatted_amount }}</td>
                                </tr>
                                <tr>
                                    <th class="text-gray-600 font-medium border-0 py-3">Payment Method</th>
                                    <td class="border-0 py-3">
                                        @if($transaction->payment_method == 'credit_card')
                                            <span class="inline-flex items-center">
                                                <i class="far fa-credit-card text-blue-500 mr-2"></i>
                                                Credit Card
                                            </span>
                                        @elseif($transaction->payment_method == 'paypal')
                                            <span class="inline-flex items-center">
                                                <i class="fab fa-paypal text-blue-600 mr-2"></i>
                                                PayPal
                                            </span>
                                        @elseif($transaction->payment_method == 'bank_transfer')
                                            <span class="inline-flex items-center">
                                                <i class="fas fa-university text-gray-600 mr-2"></i>
                                                Bank Transfer
                                            </span>
                                        @else
                                            {{ ucfirst($transaction->payment_method) }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-gray-600 font-medium border-0 py-3">Status</th>
                                    <td class="border-0 py-3">{!! $transaction->status_badge !!}</td>
                                </tr>
                                <tr>
                                    <th class="text-gray-600 font-medium border-0 py-3">Date</th>
                                    <td class="border-0 py-3">{{ $transaction->created_at->format('F d, Y h:i A') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0 text-gray-700 font-medium">Order Information</h5>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <tr>
                                    <th class="text-gray-600 font-medium border-0 py-3" style="width: 200px;">Order Number</th>
                                    <td class="border-0 py-3">
                                        <a href="{{ route('admin.orders.show', $transaction->order) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                                            {{ $transaction->order->order_number }}
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-gray-600 font-medium border-0 py-3">Order Status</th>
                                    <td class="border-0 py-3">{!! $transaction->order->status_badge !!}</td>
                                </tr>
                                <tr>
                                    <th class="text-gray-600 font-medium border-0 py-3">Payment Status</th>
                                    <td class="border-0 py-3">{!! $transaction->order->payment_status_badge !!}</td>
                                </tr>
                                <tr>
                                    <th class="text-gray-600 font-medium border-0 py-3">Order Date</th>
                                    <td class="border-0 py-3">{{ $transaction->order->created_at->format('F d, Y h:i A') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0 text-gray-700 font-medium">Customer Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-4">
                                <div class="bg-gray-200 rounded-full w-12 h-12 flex items-center justify-center mr-3">
                                    <i class="fas fa-user text-gray-500 text-xl"></i>
                                </div>
                                <div>
                                    <h6 class="font-medium text-gray-800 mb-0">
                                        <a href="{{ route('admin.users.show', $transaction->order->user) }}" class="text-indigo-600 hover:text-indigo-800">
                                            {{ $transaction->order->user->name }}
                                        </a>
                                    </h6>
                                    <p class="text-gray-500 mb-0">{{ $transaction->order->user->email }}</p>
                                </div>
                            </div>

                            @if($transaction->order->recipient_name || $transaction->order->recipient_phone)
                            <div class="mb-3">
                                <h6 class="text-sm font-medium text-gray-700 mb-2">Recipient Information</h6>
                                <p class="mb-1"><span class="text-gray-600">Name:</span> {{ $transaction->order->recipient_name }}</p>
                                <p class="mb-0"><span class="text-gray-600">Phone:</span> {{ $transaction->order->recipient_phone }}</p>
                            </div>
                            @endif

                            <div>
                                <h6 class="text-sm font-medium text-gray-700 mb-2">Shipping Address</h6>
                                <p class="text-gray-600 mb-0">
                                    {{ $transaction->order->shipping_address }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0 text-gray-700 font-medium">Payment Details</h5>
                        </div>
                        <div class="card-body">
                            @if($transaction->payment_details)
                                <table class="table">
                                    @foreach($transaction->payment_details as $key => $value)
                                        <tr>
                                            <th class="text-gray-600 font-medium border-0 py-3" style="width: 200px;">{{ ucwords(str_replace('_', ' ', $key)) }}</th>
                                            <td class="border-0 py-3">{{ $value }}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            @else
                                <div class="text-center py-4 text-gray-500">
                                    <i class="fas fa-info-circle mb-2 text-2xl"></i>
                                    <p>No payment details available</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 text-gray-700 font-medium">Order Items</h5>
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
                                @foreach($transaction->order->items as $item)
                                    <tr>
                                        <td class="py-3 px-4">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $item->product->primaryImage->url }}" alt="{{ $item->product->name }}" class="me-3 rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                                <div>
                                                    <a href="{{ route('admin.products.show', $item->product) }}" class="text-gray-800 hover:text-indigo-600 font-medium">
                                                        {{ $item->product->name }}
                                                    </a>
                                                    <p class="text-gray-500 text-sm mb-0">SKU: {{ $item->product->sku }}</p>
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
                                    <th colspan="3" class="text-right py-3 px-4 font-medium text-gray-600">Subtotal:</th>
                                    <td class="py-3 px-4 text-right font-medium">{{ $transaction->order->formatted_total_amount }}</td>
                                </tr>
                                @if($transaction->order->discount_amount > 0)
                                    <tr>
                                        <th colspan="3" class="text-right py-3 px-4 font-medium text-gray-600">Discount:</th>
                                        <td class="py-3 px-4 text-right font-medium text-red-600">-{{ $transaction->order->formatted_discount_amount }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <th colspan="3" class="text-right py-3 px-4 font-medium text-gray-800">Total:</th>
                                    <td class="py-3 px-4 text-right font-bold text-gray-800">{{ $transaction->order->formatted_final_amount }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection