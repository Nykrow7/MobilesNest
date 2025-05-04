@extends('layouts.admin')

@section('title', 'Transaction Details')

@section('content')
<div class="container-fluid px-4">
    <!-- Page Header -->
    <div class="flex justify-between items-center mt-6 mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-black">Transaction Details</h1>
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
                            <a href="{{ route('admin.transactions.index') }}" class="text-gray-700 hover:text-indigo-600">
                                Transactions
                            </a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs"></i>
                            <span class="text-gray-500">{{ $transaction->transaction_number }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="{{ route('admin.transactions.index') }}" class="inline-flex items-center px-3 py-1.5 bg-white border border-gray-300 rounded-md shadow-sm text-sm font-medium text-black hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <i class="fas fa-arrow-left mr-1.5 text-sm"></i> Back to Transactions
            </a>
        </div>
    </div>

    <!-- Transaction Summary -->
    <div class="bg-white rounded-md shadow-sm border border-gray-200 overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-medium text-black flex items-center">
                <i class="fas fa-info-circle mr-2 text-indigo-600"></i>
                Transaction Summary
            </h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-indigo-50 rounded-lg p-4">
                    <div class="text-sm text-indigo-600 mb-1">Transaction Number</div>
                    <div class="text-xl font-semibold text-black">{{ $transaction->transaction_number }}</div>
                </div>
                <div class="bg-green-50 rounded-lg p-4">
                    <div class="text-sm text-green-600 mb-1">Amount</div>
                    <div class="text-xl font-semibold text-black">{{ $transaction->formatted_amount }}</div>
                </div>
                <div class="bg-blue-50 rounded-lg p-4">
                    <div class="text-sm text-blue-600 mb-1">Status</div>
                    <div class="text-xl font-semibold">{!! $transaction->status_badge !!}</div>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="text-sm text-gray-600 mb-1">Date</div>
                    <div class="text-xl font-semibold text-black">{{ $transaction->created_at->format('M d, Y') }}</div>
                    <div class="text-sm text-gray-500">{{ $transaction->created_at->format('h:i A') }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaction Details and Order Information -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Transaction Details -->
        <div class="bg-white rounded-md shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-black">Transaction Details</h2>
            </div>
            <div class="p-6">
                <div class="divide-y divide-gray-200">
                    <div class="py-3 flex flex-col sm:flex-row">
                        <dt class="text-sm font-medium text-gray-500 sm:w-40 sm:flex-shrink-0">Transaction Number</dt>
                        <dd class="mt-1 text-sm text-black sm:mt-0 sm:ml-6">{{ $transaction->transaction_number }}</dd>
                    </div>
                    <div class="py-3 flex flex-col sm:flex-row">
                        <dt class="text-sm font-medium text-gray-500 sm:w-40 sm:flex-shrink-0">Amount</dt>
                        <dd class="mt-1 text-sm font-medium text-black sm:mt-0 sm:ml-6">{{ $transaction->formatted_amount }}</dd>
                    </div>
                    <div class="py-3 flex flex-col sm:flex-row">
                        <dt class="text-sm font-medium text-gray-500 sm:w-40 sm:flex-shrink-0">Payment Method</dt>
                        <dd class="mt-1 text-sm text-black sm:mt-0 sm:ml-6">
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
                        </dd>
                    </div>
                    <div class="py-3 flex flex-col sm:flex-row">
                        <dt class="text-sm font-medium text-gray-500 sm:w-40 sm:flex-shrink-0">Status</dt>
                        <dd class="mt-1 text-sm sm:mt-0 sm:ml-6">{!! $transaction->status_badge !!}</dd>
                    </div>
                    <div class="py-3 flex flex-col sm:flex-row">
                        <dt class="text-sm font-medium text-gray-500 sm:w-40 sm:flex-shrink-0">Date</dt>
                        <dd class="mt-1 text-sm text-black sm:mt-0 sm:ml-6">{{ $transaction->created_at->format('F d, Y h:i A') }}</dd>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Information -->
        <div class="bg-white rounded-md shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-black">Order Information</h2>
            </div>
            <div class="p-6">
                <div class="divide-y divide-gray-200">
                    <div class="py-3 flex flex-col sm:flex-row">
                        <dt class="text-sm font-medium text-gray-500 sm:w-40 sm:flex-shrink-0">Order Number</dt>
                        <dd class="mt-1 text-sm sm:mt-0 sm:ml-6">
                            <a href="{{ route('admin.orders.show', $transaction->order) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                                {{ $transaction->order->order_number }}
                            </a>
                        </dd>
                    </div>
                    <div class="py-3 flex flex-col sm:flex-row">
                        <dt class="text-sm font-medium text-gray-500 sm:w-40 sm:flex-shrink-0">Order Status</dt>
                        <dd class="mt-1 text-sm sm:mt-0 sm:ml-6">{!! $transaction->order->status_badge !!}</dd>
                    </div>
                    <div class="py-3 flex flex-col sm:flex-row">
                        <dt class="text-sm font-medium text-gray-500 sm:w-40 sm:flex-shrink-0">Payment Status</dt>
                        <dd class="mt-1 text-sm sm:mt-0 sm:ml-6">{!! $transaction->order->payment_status_badge !!}</dd>
                    </div>
                    <div class="py-3 flex flex-col sm:flex-row">
                        <dt class="text-sm font-medium text-gray-500 sm:w-40 sm:flex-shrink-0">Order Date</dt>
                        <dd class="mt-1 text-sm text-black sm:mt-0 sm:ml-6">{{ $transaction->order->created_at->format('F d, Y h:i A') }}</dd>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Customer Information and Payment Details -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Customer Information -->
        <div class="bg-white rounded-md shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-black">Customer Information</h2>
            </div>
            <div class="p-6">
                <div class="flex items-center mb-6">
                    <div class="bg-gray-200 rounded-full w-12 h-12 flex items-center justify-center mr-4 flex-shrink-0">
                        <i class="fas fa-user text-gray-500 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-medium text-black mb-1">
                            <a href="{{ route('admin.users.show', $transaction->order->user) }}" class="text-indigo-600 hover:text-indigo-800">
                                {{ $transaction->order->user->name }}
                            </a>
                        </h3>
                        <p class="text-gray-500">{{ $transaction->order->user->email }}</p>
                    </div>
                </div>

                @if($transaction->order->recipient_name || $transaction->order->recipient_phone)
                <div class="mb-6">
                    <h3 class="text-sm font-medium text-black mb-3">Recipient Information</h3>
                    <div class="bg-gray-50 rounded-md p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Name</p>
                                <p class="text-sm text-black">{{ $transaction->order->recipient_name }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Phone</p>
                                <p class="text-sm text-black">{{ $transaction->order->recipient_phone }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <div>
                    <h3 class="text-sm font-medium text-black mb-3">Shipping Address</h3>
                    <div class="bg-gray-50 rounded-md p-4">
                        <p class="text-sm text-black whitespace-pre-line">
                            {{ $transaction->order->shipping_address }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Details -->
        <div class="bg-white rounded-md shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-black">Payment Details</h2>
            </div>
            <div class="p-6">
                @if($transaction->payment_details)
                    <div class="divide-y divide-gray-200">
                        @foreach($transaction->payment_details as $key => $value)
                            <div class="py-3 flex flex-col sm:flex-row">
                                <dt class="text-sm font-medium text-gray-500 sm:w-40 sm:flex-shrink-0">{{ ucwords(str_replace('_', ' ', $key)) }}</dt>
                                <dd class="mt-1 text-sm text-black sm:mt-0 sm:ml-6">{{ $value }}</dd>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-gray-100">
                            <i class="fas fa-info-circle text-gray-500 text-xl"></i>
                        </div>
                        <h3 class="mt-2 text-sm font-medium text-black">No payment details</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            No additional payment details are available for this transaction.
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Order Items -->
    <div class="bg-white rounded-md shadow-sm border border-gray-200 overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-medium text-black">Order Items</h2>
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
                    @foreach($transaction->order->items as $item)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-12 w-12">
                                        <img src="{{ $item->product->primaryImage->url }}" alt="{{ $item->product->name }}" class="h-12 w-12 rounded-md object-cover">
                                    </div>
                                    <div class="ml-4">
                                        <a href="{{ route('admin.products.show', $item->product) }}" class="text-sm font-medium text-black hover:text-indigo-600">
                                            {{ $item->product->name }}
                                        </a>
                                        <div class="text-xs text-gray-500">SKU: {{ $item->product->sku }}</div>
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
                        <th colspan="3" class="px-6 py-3 text-right text-sm font-medium text-gray-700">Subtotal:</th>
                        <td class="px-6 py-3 text-right text-sm font-medium text-black">{{ $transaction->order->formatted_total_amount }}</td>
                    </tr>
                    @if($transaction->order->discount_amount > 0)
                        <tr>
                            <th colspan="3" class="px-6 py-3 text-right text-sm font-medium text-gray-700">Discount:</th>
                            <td class="px-6 py-3 text-right text-sm font-medium text-red-600">-{{ $transaction->order->formatted_discount_amount }}</td>
                        </tr>
                    @endif
                    <tr>
                        <th colspan="3" class="px-6 py-3 text-right text-sm font-medium text-black">Total:</th>
                        <td class="px-6 py-3 text-right text-sm font-bold text-black">{{ $transaction->order->formatted_final_amount }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection

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