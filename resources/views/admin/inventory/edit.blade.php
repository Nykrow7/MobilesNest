@extends('layouts.admin')

@section('title', 'Edit Inventory')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Edit Inventory</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-indigo-600 hover:text-indigo-800">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.inventory.index') }}" class="text-indigo-600 hover:text-indigo-800">Inventory</a></li>
                <li class="breadcrumb-item active text-gray-500">Edit {{ $inventory->product->name }}</li>
            </ol>
        </div>
        <div>
            <a href="{{ route('admin.inventory.index') }}" class="btn bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium py-2 px-4 rounded-lg shadow-sm transition duration-150 ease-in-out">
                <i class="fas fa-arrow-left me-2"></i> Back to Inventory
            </a>
        </div>
    </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Product Information</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Product Name</th>
                                            <td>{{ $inventory->product->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Brand</th>
                                            <td>{{ $inventory->product->brand }}</td>
                                        </tr>
                                        <tr>
                                            <th>Category</th>
                                            <td>{{ $inventory->product->category->name ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Price</th>
                                            <td>{{ $inventory->product->getFormattedPriceAttribute() }}</td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td>
                                                @if ($inventory->isInStock())
                                                    @if ($inventory->isLowStock())
                                                        <span class="badge badge-warning">Low Stock</span>
                                                    @else
                                                        <span class="badge badge-success">In Stock</span>
                                                    @endif
                                                @else
                                                    <span class="badge badge-danger">Out of Stock</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Update Inventory</h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('admin.inventory.update', $inventory->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="form-group">
                                            <label for="quantity">Quantity <span class="text-danger">*</span></label>
                                            <input type="number" name="quantity" id="quantity" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity', $inventory->quantity) }}" min="0" required>
                                            @error('quantity')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="low_stock_threshold">Low Stock Threshold <span class="text-danger">*</span></label>
                                            <input type="number" name="low_stock_threshold" id="low_stock_threshold" class="form-control @error('low_stock_threshold') is-invalid @enderror" value="{{ old('low_stock_threshold', $inventory->low_stock_threshold) }}" min="1" required>
                                            @error('low_stock_threshold')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                            <small class="form-text text-muted">When inventory falls below this threshold, it will be marked as low stock.</small>
                                        </div>

                                        <div class="flex justify-end space-x-4 mt-6">
                                            <a href="{{ route('admin.inventory.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                <i class="fas fa-times mr-1"></i> Cancel
                                            </a>
                                            <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                <i class="fas fa-save mr-1"></i> Update Inventory
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection