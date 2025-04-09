@extends('layouts.admin')

@section('title', 'Order Details')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Order Details</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Orders</a></li>
        <li class="breadcrumb-item active">Order #{{ $order->order_number }}</li>
    </ol>
    
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-info-circle me-1"></i>
                        Order Information
                    </div>
                    <div>
                        <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit"></i> Edit Order
                        </a>
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Orders
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="card-title">Order Details</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 200px;">Order Number</th>
                                    <td>{{ $order->order_number }}</td>
                                </tr>
                                <tr>
                                    <th>Date</th>
                                    <td>{{ $order->created_at->format('F d, Y h:i A') }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>{!! $order->status_badge !!}</td>
                                </tr>
                                <tr>
                                    <th>Payment Method</th>
                                    <td>{{ ucfirst($order->payment_method) }}</td>
                                </tr>
                                <tr>
                                    <th>Payment Status</th>
                                    <td>{!! $order->payment_status_badge !!}</td>
                                </tr>
                                <tr>
                                    <th>Total Amount</th>
                                    <td>{{ $order->formatted_total_amount }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5 class="card-title">Shipping Information</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 200px;">Shipping Status</th>
                                    <td>{!! $order->shipping_status_badge !!}</td>
                                </tr>
                                @if($order->tracking_number)
                                <tr>
                                    <th>Tracking Number</th>
                                    <td>{{ $order->tracking_number }}</td>
                                </tr>
                                @endif
                                @if($order->shipped_at)
                                <tr>
                                    <th>Shipped Date</th>
                                    <td>{{ $order->shipped_at->format('F d, Y') }}</td>
                                </tr>
                                @endif
                                @if($order->delivered_at)
                                <tr>
                                    <th>Delivered Date</th>
                                    <td>{{ $order->delivered_at->format('F d, Y') }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <th>Shipping Address</th>
                                    <td>{{ $order->shipping_address }}</td>
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
                                    <td>{{ $order->user->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $order->user->email }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5 class="card-title">Notes</h5>
                            <div class="card">
                                <div class="card-body">
                                    {{ $order->notes ?? 'No notes available' }}
                                </div>
                            </div>
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
                                @foreach($order->items as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($item->product->primaryImage)
                                                <img src="{{ asset('storage/' . $item->product->primaryImage->image_path) }}" alt="{{ $item->product->name }}" class="me-2" style="width: 50px; height: 50px; object-fit: cover;">
                                                @endif
                                                <div>
                                                    {{ $item->product->name }}
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
                                    <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                    <td>{{ $order->formatted_total_amount }}</td>
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
