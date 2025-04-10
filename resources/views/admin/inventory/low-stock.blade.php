@extends('layouts.admin')

@section('title', 'Low Stock Items')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Low Stock Items</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-indigo-600 hover:text-indigo-800">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.inventory.index') }}" class="text-indigo-600 hover:text-indigo-800">Inventory</a></li>
                <li class="breadcrumb-item active text-gray-500">Low Stock</li>
            </ol>
        </div>
        <div>
            <a href="{{ route('admin.inventory.index') }}" class="btn bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium py-2 px-4 rounded-lg shadow-sm transition duration-150 ease-in-out">
                <i class="fas fa-arrow-left me-2"></i> Back to Inventory
            </a>
        </div>
    </div>
    
    @if (session('success'))
        <div class="alert bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            <div class="flex items-center">
                <div class="py-1"><i class="fas fa-check-circle text-green-500 mr-2"></i></div>
                <div>
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif
    
    <div class="card mb-4 shadow-sm border-0 overflow-hidden">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <div class="text-indigo-700 font-medium">
                <i class="fas fa-exclamation-triangle me-2 text-yellow-600"></i>
                Low Stock Items
            </div>
            <div class="text-sm text-gray-500">
                Total: <span class="font-medium">{{ $lowStockItems->total() }}</span> items
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover" id="lowStockTable" width="100%" cellspacing="0">
                    <thead class="bg-gray-50 text-gray-600 text-sm">
                        <tr>
                            <th class="py-3 px-4 font-medium">ID</th>
                            <th class="py-3 px-4 font-medium">Product</th>
                            <th class="py-3 px-4 font-medium">Brand</th>
                            <th class="py-3 px-4 font-medium">Current Quantity</th>
                            <th class="py-3 px-4 font-medium">Low Stock Threshold</th>
                            <th class="py-3 px-4 font-medium">Status</th>
                            <th class="py-3 px-4 font-medium">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($lowStockItems as $item)
                            <tr class="hover:bg-gray-50 transition-colors duration-150 bg-yellow-50">
                                <td class="py-3 px-4">{{ $item->id }}</td>
                                <td class="py-3 px-4 font-medium">
                                    <a href="{{ route('admin.products.edit', $item->product_id) }}" class="text-indigo-600 hover:text-indigo-900">
                                        {{ $item->product->name }}
                                    </a>
                                </td>
                                <td class="py-3 px-4">{{ $item->product->brand }}</td>
                                <td class="py-3 px-4 font-medium">{{ $item->quantity }}</td>
                                <td class="py-3 px-4">{{ $item->low_stock_threshold }}</td>
                                <td class="py-3 px-4">
                                    <span class="px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Low Stock</span>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.inventory.edit', $item->id) }}" class="btn bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium py-1 px-3 rounded-lg transition duration-150 ease-in-out shadow-sm" data-bs-toggle="tooltip" title="Edit Inventory">
                                            <i class="fas fa-edit mr-1"></i> Edit
                                        </a>
                                        <button type="button" class="btn bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-1 px-3 rounded-lg transition duration-150 ease-in-out shadow-sm" data-bs-toggle="modal" data-bs-target="#adjustModal{{ $item->id }}">
                                            <i class="fas fa-arrows-alt-v mr-1"></i> Adjust
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-6 text-center text-gray-500">No low stock items found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="px-4 py-3 border-t border-gray-200">
                {{ $lowStockItems->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Adjustment Modals -->
@foreach ($lowStockItems as $item)
    <div class="modal fade" id="adjustModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="adjustModalLabel{{ $item->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content rounded-lg shadow-lg border-0">
                <form action="{{ route('admin.inventory.adjust', $item->id) }}" method="POST">
                    @csrf
                    <div class="modal-header bg-gray-50 border-b border-gray-100 py-3">
                        <h5 class="modal-title text-gray-800 font-medium" id="adjustModalLabel{{ $item->id }}">
                            <i class="fas fa-boxes me-2 text-indigo-600"></i>Adjust Inventory for {{ $item->product->name }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-4">
                            <label for="adjustment" class="form-label text-gray-700 font-medium mb-2">Quantity Adjustment</label>
                            <div class="input-group">
                                <button type="button" class="btn bg-red-500 hover:bg-red-600 text-white decrease-btn">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number" name="adjustment" id="adjustment" class="form-control border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="0" required>
                                <button type="button" class="btn bg-green-500 hover:bg-green-600 text-white increase-btn">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <small class="text-gray-500 mt-1 block">
                                Current quantity: {{ $item->quantity }}. Use positive values to increase, negative to decrease.
                            </small>
                        </div>
                        <div class="mb-3">
                            <label for="reason" class="form-label text-gray-700 font-medium mb-2">Reason for Adjustment</label>
                            <select name="reason" id="reason" class="form-select border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" required>
                                <option value="">Select a reason</option>
                                <option value="New Stock">New Stock</option>
                                <option value="Inventory Count">Inventory Count</option>
                                <option value="Damaged">Damaged</option>
                                <option value="Return">Return</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer bg-gray-50 border-t border-gray-100 py-3">
                        <button type="button" class="btn bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-2 px-4 rounded-lg transition duration-150 ease-in-out" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition duration-150 ease-in-out shadow-sm">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

@push('scripts')
<script>
    $(document).ready(function() {
        // Make table headers sortable
        $('#lowStockTable th').css('cursor', 'pointer').hover(function() {
            $(this).addClass('text-indigo-700');
        }, function() {
            $(this).removeClass('text-indigo-700');
        });
        
        // Quantity adjustment buttons
        $('.decrease-btn').on('click', function() {
            const input = $(this).closest('.input-group').find('input');
            input.val(parseInt(input.val()) - 1);
        });
        
        $('.increase-btn').on('click', function() {
            const input = $(this).closest('.input-group').find('input');
            input.val(parseInt(input.val()) + 1);
        });
        
        // Add tooltips to action buttons
        $('[data-bs-toggle="tooltip"]').tooltip();
    });
</script>
@endpush
@endsection
