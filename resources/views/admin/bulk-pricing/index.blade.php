@extends('layouts.admin')

@section('title', 'Bulk Pricing Tiers for ' . $product->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Bulk Pricing Tiers for {{ $product->name }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.bulk-pricing.create', $product->id) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Add New Tier
                        </a>
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-secondary btn-sm ml-2">
                            <i class="fas fa-arrow-left"></i> Back to Product
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Min Quantity</th>
                                    <th>Max Quantity</th>
                                    <th>Price</th>
                                    <th>Discount %</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bulkPricingTiers as $tier)
                                    <tr>
                                        <td>{{ $tier->min_quantity }}</td>
                                        <td>{{ $tier->max_quantity ?? 'No limit' }}</td>
                                        <td>${{ number_format($tier->price, 2) }}</td>
                                        <td>{{ $tier->discount_percentage ? $tier->discount_percentage . '%' : 'N/A' }}</td>
                                        <td>
                                            @if($tier->is_active)
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('admin.bulk-pricing.edit',