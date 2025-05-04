@extends('layouts.admin')

@section('title', 'Low Stock Items')

@section('content')
<div class="container-fluid px-4">
    <div class="flex justify-between items-center mt-4 mb-4">
        <div>
            <h1 class="text-2xl font-semibold text-primary-900">Low Stock Items</h1>
            <ol class="flex items-center space-x-2 text-sm mt-1">
                <li><a href="{{ route('admin.dashboard') }}" class="text-primary-700 hover:text-primary-900">Dashboard</a></li>
                <li class="flex items-center">
                    <svg class="h-4 w-4 text-primary-400 mx-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    <a href="{{ route('admin.inventory.index') }}" class="text-primary-700 hover:text-primary-900">Inventory</a>
                </li>
                <li class="flex items-center">
                    <svg class="h-4 w-4 text-primary-400 mx-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    <span class="text-primary-600">Low Stock</span>
                </li>
            </ol>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.inventory.export') }}" class="flex items-center bg-white border border-primary-200 hover:bg-primary-50 text-primary-800 font-medium py-2 px-4 rounded-lg shadow-sm transition duration-150 ease-in-out">
                <svg class="h-4 w-4 text-primary-700 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Export CSV
            </a>
            <a href="{{ route('admin.inventory.index') }}" class="flex items-center bg-white border border-primary-200 hover:bg-primary-50 text-primary-800 font-medium py-2 px-4 rounded-lg shadow-sm transition duration-150 ease-in-out">
                <svg class="h-4 w-4 text-primary-700 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Inventory
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded" role="alert">
            <div class="flex items-center">
                <div class="py-1"><svg class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg></div>
                <div>
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-sm border border-primary-100 mb-4 overflow-hidden">
        <div class="px-4 py-3 border-b border-primary-100">
            <h5 class="mb-0 text-primary-800 font-medium flex items-center">
                <svg class="h-5 w-5 text-yellow-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                Low Stock Information
            </h5>
        </div>
        <div class="p-4 bg-white">
            <p class="text-primary-700">These items are at or below their low stock threshold and may need to be restocked soon.</p>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-primary-100 mb-4 overflow-hidden">
        <div class="px-4 py-3 border-b border-primary-100 flex justify-between items-center">
            <div class="text-primary-800 font-medium flex items-center">
                <svg class="h-5 w-5 text-primary-700 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                Low Stock Items
            </div>
            <div class="text-sm text-primary-600">
                Total: <span class="font-medium">{{ $lowStockItems->total() }}</span> items
            </div>
        </div>
        <div class="p-0">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-primary-100" id="lowStockTable">
                    <thead class="bg-primary-50">
                        <tr>
                            <th class="py-3 px-4 text-left text-xs font-medium text-primary-600 uppercase tracking-wider">ID</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-primary-600 uppercase tracking-wider">Product</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-primary-600 uppercase tracking-wider">Brand</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-primary-600 uppercase tracking-wider">Quantity</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-primary-600 uppercase tracking-wider">Low Stock Threshold</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-primary-600 uppercase tracking-wider">Status</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-primary-600 uppercase tracking-wider">Last Updated</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-primary-600 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-primary-100">
                        @forelse ($lowStockItems as $item)
                            <tr class="hover:bg-primary-50 transition-colors duration-150 bg-yellow-50">
                                <td class="py-3 px-4 text-primary-700">{{ $item->id }}</td>
                                <td class="py-3 px-4 font-medium">
                                    <a href="{{ route('admin.products.edit', $item->product_id) }}" class="text-primary-700 hover:text-primary-900">
                                        {{ $item->product->name }}
                                    </a>
                                </td>
                                <td class="py-3 px-4 text-primary-700">{{ $item->product->brand }}</td>
                                <td class="py-3 px-4 font-medium text-primary-800">{{ $item->quantity }}</td>
                                <td class="py-3 px-4 text-primary-700">{{ $item->low_stock_threshold }}</td>
                                <td class="py-3 px-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Low Stock</span>
                                </td>
                                <td class="py-3 px-4 text-primary-600">{{ $item->updated_at->format('M d, Y H:i') }}</td>
                                <td class="py-3 px-4">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.inventory.edit', $item->id) }}" class="bg-primary-800 hover:bg-primary-900 text-white text-sm font-medium py-1 px-3 rounded-lg transition duration-150 ease-in-out shadow-sm flex items-center" data-bs-toggle="tooltip" title="Edit Inventory">
                                            <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Edit
                                        </a>
                                        <button type="button" class="bg-accent-800 hover:bg-accent-900 text-white text-sm font-medium py-1 px-3 rounded-lg transition duration-150 ease-in-out shadow-sm flex items-center" data-bs-toggle="modal" data-bs-target="#adjustModal{{ $item->id }}">
                                            <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                            </svg>
                                            Adjust
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-8 text-center text-primary-600 bg-primary-50">
                                    <svg class="h-12 w-12 text-primary-400 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                    <p class="font-medium">No low stock items found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-4 py-3 border-t border-primary-100">
                {{ $lowStockItems->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Adjustment Modals -->
@foreach ($lowStockItems as $item)
    <div class="modal fade" id="adjustModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="adjustModalLabel{{ $item->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content rounded-lg shadow-lg border border-primary-100">
                <form action="{{ route('admin.inventory.adjust', $item->id) }}" method="POST">
                    @csrf
                    <div class="modal-header bg-primary-50 border-b border-primary-100 py-3">
                        <h5 class="modal-title text-primary-900 font-medium flex items-center" id="adjustModalLabel{{ $item->id }}">
                            <svg class="h-5 w-5 text-primary-700 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                            </svg>
                            Adjust Inventory for {{ $item->product->name }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-4">
                            <label for="adjustment" class="block text-primary-800 font-medium mb-2">Quantity Adjustment</label>
                            <div class="flex">
                                <button type="button" class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-l-lg decrease-btn flex items-center justify-center">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                    </svg>
                                </button>
                                <input type="number" name="adjustment" id="adjustment" class="w-full border-primary-200 focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50 text-center" value="0" required>
                                <button type="button" class="bg-green-500 hover:bg-green-600 text-white px-3 py-2 rounded-r-lg increase-btn flex items-center justify-center">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                </button>
                            </div>
                            <p class="text-primary-600 text-sm mt-2">
                                Current quantity: <span class="font-medium">{{ $item->quantity }}</span>. Use positive values to increase, negative to decrease.
                            </p>
                        </div>
                        <div class="mb-3">
                            <label for="reason" class="block text-primary-800 font-medium mb-2">Reason for Adjustment</label>
                            <select name="reason" id="reason" class="w-full rounded-md border-primary-200 focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50 shadow-sm" required>
                                <option value="">Select a reason</option>
                                <option value="New Stock">New Stock</option>
                                <option value="Inventory Count">Inventory Count</option>
                                <option value="Damaged">Damaged</option>
                                <option value="Return">Return</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer bg-primary-50 border-t border-primary-100 py-3">
                        <button type="button" class="bg-white border border-primary-200 hover:bg-primary-50 text-primary-800 font-medium py-2 px-4 rounded-lg transition duration-150 ease-in-out" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="bg-primary-800 hover:bg-primary-900 text-white font-medium py-2 px-4 rounded-lg transition duration-150 ease-in-out shadow-sm">Save Changes</button>
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
            $(this).addClass('text-primary-800');
        }, function() {
            $(this).removeClass('text-primary-800');
        });

        // Quantity adjustment buttons
        $('.decrease-btn').on('click', function() {
            const input = $(this).closest('.flex').find('input');
            input.val(parseInt(input.val()) - 1);
        });

        $('.increase-btn').on('click', function() {
            const input = $(this).closest('.flex').find('input');
            input.val(parseInt(input.val()) + 1);
        });

        // Add tooltips to action buttons
        $('[data-bs-toggle="tooltip"]').tooltip();
    });
</script>
@endpush
@endsection
