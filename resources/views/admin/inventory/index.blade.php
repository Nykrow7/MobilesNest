@extends('layouts.admin')

@section('title', 'Inventory Management')

@section('content')
<div class="container-fluid px-4">
    <div class="flex justify-between items-center mt-4 mb-4">
        <div>
            <h1 class="text-2xl font-semibold text-primary-900">Inventory Management</h1>
            <ol class="flex items-center space-x-2 text-sm mt-1">
                <li><a href="{{ route('admin.dashboard') }}" class="text-primary-700 hover:text-primary-900">Dashboard</a></li>
                <li class="flex items-center">
                    <svg class="h-4 w-4 text-primary-400 mx-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    <span class="text-primary-600">Inventory</span>
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
            <a href="{{ route('admin.inventory.low-stock') }}" class="flex items-center bg-white border border-primary-200 hover:bg-primary-50 text-primary-800 font-medium py-2 px-4 rounded-lg shadow-sm transition duration-150 ease-in-out">
                <svg class="h-4 w-4 text-primary-700 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                Low Stock Items
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-primary-100 mb-4 overflow-hidden">
        <div class="px-4 py-3 border-b border-primary-100">
            <h5 class="mb-0 text-primary-800 font-medium flex items-center">
                <svg class="h-5 w-5 text-primary-700 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                Filter Inventory
            </h5>
        </div>
        <div class="p-4 bg-white">
            <form action="{{ route('admin.inventory.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-4">
                <div class="md:col-span-6">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="h-5 w-5 text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" class="w-full pl-10 shadow-sm border-primary-200 rounded-lg focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50" placeholder="Search by product name or brand" value="{{ request('search') }}">
                    </div>
                </div>
                <div class="md:col-span-3 flex items-center">
                    <div class="flex items-center">
                        <input class="rounded border-primary-300 text-primary-600 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50" type="checkbox" name="low_stock" id="low_stock" value="1" {{ request('low_stock') ? 'checked' : '' }}>
                        <label class="ml-2 text-primary-700" for="low_stock">
                            Show only low stock items
                        </label>
                    </div>
                </div>
                <div class="md:col-span-3 flex items-center justify-end space-x-2">
                    <button type="submit" class="bg-primary-800 hover:bg-primary-900 text-white font-medium py-2 px-4 rounded-lg transition duration-150 ease-in-out shadow-sm flex items-center">
                        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        Apply Filters
                    </button>
                    <a href="{{ route('admin.inventory.index') }}" class="bg-white border border-primary-200 hover:bg-primary-50 text-primary-800 font-medium py-2 px-4 rounded-lg transition duration-150 ease-in-out flex items-center">
                        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-primary-100 mb-4 overflow-hidden">
        <div class="px-4 py-3 border-b border-primary-100 flex justify-between items-center">
            <div class="text-primary-800 font-medium flex items-center">
                <svg class="h-5 w-5 text-primary-700 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                Inventory Items
            </div>
            <div class="text-sm text-primary-600">
                Total: <span class="font-medium">{{ $inventory->total() }}</span> items
            </div>
        </div>
        <div class="p-0">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-primary-100" id="inventoryTable">
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
                        @forelse ($inventory as $item)
                            <tr class="hover:bg-primary-50 transition-colors duration-150 {{ $item->isLowStock() ? 'bg-primary-50' : '' }}">
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
                                    @if ($item->isInStock())
                                        @if ($item->isLowStock())
                                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Low Stock</span>
                                        @else
                                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-primary-100 text-primary-800">In Stock</span>
                                        @endif
                                    @else
                                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">Out of Stock</span>
                                    @endif
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
                                    No inventory items found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-4 py-3 border-t border-primary-100">
                {{ $inventory->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Adjustment Modals -->
@foreach ($inventory as $item)
    <div class="modal fade" id="adjustModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="adjustModalLabel{{ $item->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content rounded-lg shadow-lg border border-gray-200">
                <form action="{{ route('admin.inventory.adjust', $item->id) }}" method="POST">
                    @csrf
                    <div class="modal-header bg-gray-50 border-b border-gray-200 py-3">
                        <h5 class="modal-title text-gray-900 font-medium text-sm" id="adjustModalLabel{{ $item->id }}">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-indigo-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                </svg>
                                <span>Adjust Inventory</span>
                            </div>
                            <div class="text-xs text-gray-500 mt-1 font-normal">{{ $item->product->name }}</div>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="space-y-4">
                            <div>
                                <label for="adjustment{{ $item->id }}" class="block text-sm font-medium text-gray-700 mb-1">Quantity Adjustment</label>
                                <div class="flex items-center">
                                    <button type="button" class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded-l-md decrease-btn flex items-center justify-center">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                        </svg>
                                    </button>
                                    <input type="number" name="adjustment" id="adjustment{{ $item->id }}" class="w-20 border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-center" value="0" required>
                                    <button type="button" class="bg-green-500 hover:bg-green-600 text-white px-2 py-1 rounded-r-md increase-btn flex items-center justify-center">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                    </button>
                                </div>
                                <p class="text-gray-500 text-xs mt-1">
                                    Current quantity: <span class="font-medium">{{ $item->quantity }}</span>
                                </p>
                                <p class="text-gray-500 text-xs">
                                    Use positive values to increase, negative to decrease.
                                </p>
                            </div>

                            <div>
                                <label for="reason{{ $item->id }}" class="block text-sm font-medium text-gray-700 mb-1">Reason for Adjustment</label>
                                <select name="reason" id="reason{{ $item->id }}" class="w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 shadow-sm text-sm" required>
                                    <option value="">Select a reason</option>
                                    <option value="New Stock">New Stock</option>
                                    <option value="Inventory Count">Inventory Count</option>
                                    <option value="Damaged">Damaged</option>
                                    <option value="Return">Return</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-gray-50 border-t border-gray-200 py-3 flex justify-end space-x-2">
                        <button type="button" class="px-3 py-1.5 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button type="submit" class="px-3 py-1.5 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Save Changes
                        </button>
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
        $('#inventoryTable th').css('cursor', 'pointer').hover(function() {
            $(this).addClass('text-primary-800');
        }, function() {
            $(this).removeClass('text-primary-800');
        });

        // Quantity adjustment buttons
        $('.decrease-btn').on('click', function() {
            const input = $(this).closest('.flex').find('input');
            const currentVal = parseInt(input.val()) || 0;
            input.val(currentVal - 1);
        });

        $('.increase-btn').on('click', function() {
            const input = $(this).closest('.flex').find('input');
            const currentVal = parseInt(input.val()) || 0;
            input.val(currentVal + 1);
        });

        // Add tooltips to action buttons
        $('[data-bs-toggle="tooltip"]').tooltip();
    });
</script>
@endpush
@endsection