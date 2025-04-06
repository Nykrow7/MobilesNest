@extends('layouts.admin')

@section('title', 'Transaction Details')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Transaction Details</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.transactions.index') }}">Transactions</a></li>
        <li class="breadcrumb-item active">{{ $transaction->transaction_number }}</li>
    </ol>
    
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-info-circle me-1"></i>
                        Transaction Information
                    </div>
                    <div>
                        <a href="{{ route('admin.transactions.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Transactions
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="card-title">Transaction Details</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 200px;">Transaction Number</th>
                                    <td>{{ $transaction->transaction_number }}</td>
                                </tr>
                                <tr>
                                    <th>Amount</th>
                                    <td>{{ $transaction->formatted_amount }}</td>
                                </tr>
                                <tr>
                                    <th>Payment Method</th>
                                    <td>{{ ucfirst($transaction->payment_method) }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>{!! $transaction->status_badge !!}</td>
                                </tr>
                                <tr>
                                    <th>Date</th>
                                    <td>{{ $transaction->created_at->format('F d, Y h:i A') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5 class="card-title">Order Information</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 200px;">Order Number</th>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $transaction->order) }}">
                                            {{ $transaction->order->order_number }}
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Order Status</th>
                                    <td>{!! $transaction->order->status_badge !!}</td>
                                </tr>
                                <tr>
                                    <th>Payment Status</th>
                                    <td>{!! $transaction->order->payment_status_badge !!}</td>
                                </tr>
                                <tr>
                                    <th>Order Date</th>
                                    <td>{{ $transaction->order->created_at->format('F d, Y h:i A') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="card-title">Customer Information</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 200px;">Name</th>
                                    <td>
                                        <a href="{{ route('admin.users.show', $transaction->order->user) }}">
                                            {{ $transaction->order->user->name }}
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $transaction->order->user->email }}</td>
                                </tr>
                                @php
                                    $shippingAddress = json_decode($transaction->order->shipping_address, true);
                                @endphp
                                @if($shippingAddress)
                                <tr>
                                    <th>Phone</th>
                                    <td>{{ $shippingAddress['phone'] ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td>
                                        {{ $shippingAddress['address'] ?? '' }}<br>
                                        {{ $shippingAddress['city'] ?? '' }}, {{ $shippingAddress['state'] ?? '' }} {{ $shippingAddress['postal_code'] ?? '' }}<br>
                                        {{ $shippingAddress['country'] ?? '' }}
                                    </td>
                                </tr>
                                @endif
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5 class="card-title">Payment Details</h5>
                            <table class="table table-bordered">
                                @if($transaction->payment_details)
                                    @foreach($transaction->payment_details as $key => $value)
                                        <tr>
                                            <th style="width: 200px;">{{ ucwords(str_replace('_', ' ', $key)) }}</th>
                                            <td>{{ $value }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="2" class="text-center">No payment details available</td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                    
                    <h5 class="card-title">Order Items</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transaction->order->items as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $item->product->primaryImage->url }}" alt="{{ $item->product->name }}" class="me-2" style="width: 50px; height: 50px; object-fit: cover;">
                                                <div>
                                                    <a href="{{ route('admin.products.show', $item->product) }}">
                                                        {{ $item->product->name }}
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $item->formatted_unit_price }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ $item->formatted_subtotal }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-end">Subtotal:</th>
                                    <td>{{ $transaction->order->formatted_total_amount }}</td>
                                </tr>
                                @if($transaction->order->discount_amount > 0)
                                    <tr>
                                        <th colspan="3" class="text-end">Discount:</th>
                                        <td>-{{ $transaction->order->formatted_discount_amount }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <th colspan="3" class="text-end">Total:</th>
                                    <td>{{ $transaction->order->formatted_final_amount }}</td>
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