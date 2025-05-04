@extends('layouts.admin')

@section('title', 'Low Stock Items')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow border mb-4">
                <div class="card-body py-3 px-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="h3 mb-2 text-dark fw-bold">Low Stock Items</h1>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb bg-transparent p-0 mb-0">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-primary">
                                            <i class="fas fa-home me-1"></i> Dashboard
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.inventory.index') }}" class="text-decoration-none text-primary">
                                            <i class="fas fa-boxes me-1"></i> Inventory
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item active fw-medium" aria-current="page">
                                        <i class="fas fa-exclamation-triangle me-1 text-warning"></i> Low Stock
                                    </li>
                                </ol>
                            </nav>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.inventory.export') }}" class="btn btn-outline-primary px-1 d-flex align-items-center">
                                <i class="fas fa-file-export me-1"></i> Export CSV
                            </a>
                            <a href="{{ route('admin.inventory.index') }}" class="btn btn-outline-secondary px-4 d-flex align-items-center">
                                <i class="fas fa-arrow-left me-2"></i> Back to Inventory
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-5 border">
        <div class="card-header bg-white py-1 border-bottom">
            <h6 class="m-0 font-weight-bold text-dark">
                <i class="fas fa-exclamation-triangle text-warning me-2"></i>Low Stock Information
            </h6>
        </div>
        <div class="card-body py-4 px-4 bg-light-subtle">
            <div class="d-flex">
                <div class="flex-shrink-0 me-3">
                    <i class="fas fa-info-circle text-primary fs-4"></i>
                </div>
                <div>
                    <p class="mb-0 fs-6">These items are at or below their low stock threshold and may need to be restocked soon. Please review the inventory levels and consider placing orders for items that are running low.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-5 border">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
            <h6 class="m-0 font-weight-bold text-dark">
                <i class="fas fa-clipboard-list me-2 text-primary"></i>Low Stock Items
            </h6>
            <div>
                <span class="badge bg-primary rounded-pill px-3 py-2 fw-normal">
                    <i class="fas fa-cubes me-1"></i> Total: {{ $lowStockItems->total() }}
                </span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-striped mb-0">
                    <thead>
                        <tr class="bg-light">
                            <th class="py-3 px-4 text-uppercase text-center" style="width: 5%">ID</th>
                            <th class="py-3 px-4 text-uppercase" style="width: 20%">Product</th>
                            <th class="py-3 px-4 text-uppercase" style="width: 15%">Brand</th>
                            <th class="py-3 px-4 text-uppercase text-center" style="width: 10%">Quantity</th>
                            <th class="py-3 px-4 text-uppercase text-center" style="width: 10%">Low Stock Threshold</th>
                            <th class="py-3 px-4 text-uppercase text-center" style="width: 10%">Status</th>
                            <th class="py-3 px-4 text-uppercase" style="width: 15%">Last Updated</th>
                            <th class="py-3 px-4 text-uppercase text-center" style="width: 15%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($lowStockItems as $item)
                            <tr class="{{ $item->quantity == 0 ? 'table-danger' : 'bg-warning-subtle' }}">
                                <td class="py-3 px-4 text-center align-middle">{{ $item->id }}</td>
                                <td class="py-3 px-4 fw-medium align-middle">
                                    <a href="{{ route('admin.products.edit', $item->product_id) }}" class="text-decoration-none text-primary">
                                        {{ $item->product->name }}
                                    </a>
                                </td>
                                <td class="py-3 px-4 align-middle">{{ $item->product->brand }}</td>
                                <td class="py-3 px-4 fw-medium text-center align-middle">{{ $item->quantity }}</td>
                                <td class="py-3 px-4 text-center align-middle">{{ $item->low_stock_threshold }}</td>
                                <td class="py-3 px-4 text-center align-middle">
                                    @if ($item->quantity > 0)
                                        <span class="badge bg-warning text-dark px-3 py-2 d-inline-block w-100">Low Stock</span>
                                    @else
                                        <span class="badge bg-danger px-3 py-2 d-inline-block w-100">Out of Stock</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 align-middle">{{ $item->updated_at->format('M d, Y H:i') }}</td>
                                <td class="py-3 px-4 text-center align-middle">
                                    <div class="d-flex gap-2 justify-content-center">
                                        <a href="{{ route('admin.inventory.edit', $item->id) }}" class="btn btn-sm btn-primary px-3" data-bs-toggle="tooltip" title="Edit Inventory">
                                            <i class="fas fa-edit me-2"></i> Edit
                                        </a>
                                        <button type="button" class="btn btn-sm btn-secondary px-3" data-bs-toggle="modal" data-bs-target="#adjustModal{{ $item->id }}">
                                            <i class="fas fa-sliders-h me-2"></i> Adjust
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 bg-light">
                                    <div class="py-4">
                                        <i class="fas fa-box-open text-muted mb-4" style="font-size: 3rem;"></i>
                                        <p class="mb-0 fw-medium fs-5">No low stock items found.</p>
                                        <p class="text-muted mt-2">All inventory items are above their threshold levels.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center py-3 px-4 border-top bg-light">
                <div class="text-muted small">
                    Showing {{ $lowStockItems->firstItem() ?? 0 }} to {{ $lowStockItems->lastItem() ?? 0 }} of {{ $lowStockItems->total() }} items
                </div>
                <div>
                    {{ $lowStockItems->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Adjustment Modals -->
@foreach ($lowStockItems as $item)
    <div class="modal fade" id="adjustModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="adjustModalLabel{{ $item->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow">
                <form action="{{ route('admin.inventory.adjust', $item->id) }}" method="POST">
                    @csrf
                    <div class="modal-header bg-light py-3">
                        <h5 class="modal-title fw-bold" id="adjustModalLabel{{ $item->id }}">
                            <i class="fas fa-sliders-h text-primary me-2"></i>Adjust Inventory for {{ $item->product->name }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="alert alert-info d-flex align-items-center mb-4 py-3">
                            <i class="fas fa-info-circle me-3 fs-5"></i>
                            <div>
                                Current quantity: <strong>{{ $item->quantity }}</strong><br>
                                Low stock threshold: <strong>{{ $item->low_stock_threshold }}</strong>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="adjustment" class="form-label fw-medium mb-2">Quantity Adjustment</label>
                            <div class="input-group">
                                <button type="button" class="btn btn-danger decrease-btn px-3 py-2">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number" name="adjustment" id="adjustment" class="form-control text-center py-2" value="0" required>
                                <button type="button" class="btn btn-success increase-btn px-3 py-2">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <div class="form-text mt-2">
                                Use positive values to increase inventory, negative values to decrease.
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="reason" class="form-label fw-medium mb-2">Reason for Adjustment</label>
                            <select name="reason" id="reason" class="form-select py-2" required>
                                <option value="">Select a reason</option>
                                <option value="New Stock">New Stock</option>
                                <option value="Inventory Count">Inventory Count</option>
                                <option value="Damaged">Damaged</option>
                                <option value="Return">Return</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer bg-light py-3">
                        <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fas fa-save me-2"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Quantity adjustment buttons
        const decreaseBtns = document.querySelectorAll('.decrease-btn');
        const increaseBtns = document.querySelectorAll('.increase-btn');

        decreaseBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const input = this.closest('.input-group').querySelector('input');
                const currentValue = parseInt(input.value) || 0;
                input.value = currentValue - 1;

                // Add visual feedback
                input.classList.add('bg-light');
                setTimeout(() => {
                    input.classList.remove('bg-light');
                }, 200);
            });
        });

        increaseBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const input = this.closest('.input-group').querySelector('input');
                const currentValue = parseInt(input.value) || 0;
                input.value = currentValue + 1;

                // Add visual feedback
                input.classList.add('bg-light');
                setTimeout(() => {
                    input.classList.remove('bg-light');
                }, 200);
            });
        });

        // Add hover effect to table rows for better UX
        const tableRows = document.querySelectorAll('tbody tr');
        tableRows.forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.classList.add('shadow-sm');
            });
            row.addEventListener('mouseleave', function() {
                this.classList.remove('shadow-sm');
            });
        });
    });
</script>
@endpush
@endsection