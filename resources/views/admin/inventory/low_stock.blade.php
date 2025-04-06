@extends('layouts.app')

@section('title', 'Low Stock Items')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Low Stock Items</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.inventory.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Inventory
                        </a>
                        <a href="{{ route('admin.inventory.export') }}" class="btn btn-sm btn-success">
                            <i class="fas fa-file-export"></i> Export CSV
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i> These items are at or below their low stock threshold and may need to be restocked soon.
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Product</th>
                                    <th>Brand</th>
                                    <th>Quantity</th>
                                    <th>Low Stock Threshold</th>
                                    <th>Status</th>
                                    <th>Last Updated</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($lowStockItems as $item)
                                    <tr class="{{ $item->quantity == 0 ? 'table-danger' : 'table-warning' }}">
                                        <td>{{ $item->id }}</td>
                                        <td>
                                            <a href="{{ route('admin.products.edit', $item->product_id) }}">
                                                {{ $item->product->name }}
                                            </a>
                                        </td>
                                        <td>{{ $item->product->brand }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ $item->low_stock_threshold }}</td>
                                        <td>
                                            @if ($item->quantity > 0)
                                                <span class="badge badge-warning">Low Stock</span>
                                            @else
                                                <span class="badge badge-danger">Out of Stock</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->updated_at->format('Y-m-d H:i:s') }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('admin.inventory.edit', $item->id) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#adjustModal{{ $item->id }}">
                                                    <i class="fas fa-plus-minus"></i> Adjust
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No low stock items found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $lowStockItems->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Adjustment Modals -->
@foreach ($lowStockItems as $item)
    <div class="modal fade" id="adjustModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="adjustModalLabel{{ $item->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('admin.inventory.adjust', $item->id) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="adjustModalLabel{{ $item->id }}">Adjust Inventory for {{ $item->product->name }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="adjustment">Quantity Adjustment</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <button type="button" class="btn btn-danger decrease-btn">-</button>
                                </div>
                                <input type="number" name="adjustment" id="adjustment" class="form-control" value="0" required>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-success increase-btn">+</button>
                                </div>
                            </div>
                            <small class="form-text text-muted">
                                Current quantity: {{ $item->quantity }}. Use positive values to increase, negative to decrease.
                            </small>
                        </div>
                        <div class="form-group">
                            <label for="reason">Reason for Adjustment</label>
                            <select name="reason" id="reason" class="form-control" required>
                                <option value="">Select a reason</option>
                                <option value="New Stock">New Stock</option>
                                <option value="Inventory Count">Inventory Count</option>
                                <option value="Damaged">Damaged</option>
                                <option value="Return">Return</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Quantity adjustment buttons
        const decreaseBtns = document.querySelectorAll('.decrease-btn');
        const increaseBtns = document.querySelectorAll('.increase-btn');
        
        decreaseBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const input = this.closest('.input-group').querySelector('input');
                input.value = parseInt(input.value) - 1;
            });
        });
        
        increaseBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const input = this.closest('.input-group').querySelector('input');
                input.value = parseInt(input.value) + 1;
            });
        });
    });
</script>
@endpush
@endsection