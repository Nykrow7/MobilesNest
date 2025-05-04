@extends('admin.layouts.app')

@section('admin-content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">Manage Orders</h2>
                    <div class="flex space-x-3">
                        <button type="button" class="inline-flex items-center px-3 py-1.5 bg-white border border-gray-300 rounded-md shadow-sm text-sm font-medium text-black hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" id="refreshTable">
                            <i class="fas fa-sync-alt mr-1.5 text-sm"></i> Refresh
                        </button>
                        <div class="relative inline-block text-left" id="exportDropdownContainer">
                            <button type="button" class="inline-flex items-center px-3 py-1.5 bg-white border border-gray-300 rounded-md shadow-sm text-sm font-medium text-black hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" id="exportDropdownButton">
                                <i class="fas fa-download mr-1.5 text-sm"></i> Export
                                <i class="fas fa-chevron-down ml-1.5 text-xs"></i>
                            </button>
                            <div id="exportDropdownMenu" class="hidden absolute right-0 z-10 mt-1 w-48 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                                <div class="py-1">
                                    <a class="export-option block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-indigo-600 transition-colors duration-150" href="#" data-export-type="csv">
                                        <i class="fas fa-file-csv mr-2 text-green-600"></i> CSV
                                    </a>
                                    <a class="export-option block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-indigo-600 transition-colors duration-150" href="#" data-export-type="excel">
                                        <i class="fas fa-file-excel mr-2 text-green-600"></i> Excel
                                    </a>
                                    <a class="export-option block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-indigo-600 transition-colors duration-150" href="#" data-export-type="pdf">
                                        <i class="fas fa-file-pdf mr-2 text-red-600"></i> PDF
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded relative" role="alert">
                    {{ session('success') }}
                    <button type="button" class="absolute top-0 right-0 px-4 py-3" data-bs-dismiss="alert" aria-label="Close">
                        <span class="sr-only">Close</span>
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                @endif

                <!-- Filters Section -->
                <div class="mb-6 p-4 bg-gray-50 border border-gray-200 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-700 mb-3 flex items-center">
                        <i class="fas fa-filter mr-2 text-indigo-600"></i>
                        Filter Orders
                    </h3>
                    <form action="{{ route('admin.orders.index') }}" method="GET">
                        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            <!-- Status Filter -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Order Status</label>
                                <select name="status" id="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Statuses</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                    <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>

                            <!-- From Date Filter -->
                            <div>
                                <label for="from_date" class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <i class="fas fa-calendar-alt text-gray-400"></i>
                                    </div>
                                    <input type="date" class="w-full pl-10 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" id="from_date" name="from_date" value="{{ request('from_date') }}">
                                </div>
                            </div>

                            <!-- To Date Filter -->
                            <div>
                                <label for="to_date" class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <i class="fas fa-calendar-alt text-gray-400"></i>
                                    </div>
                                    <input type="date" class="w-full pl-10 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" id="to_date" name="to_date" value="{{ request('to_date') }}">
                                </div>
                            </div>

                            <!-- Search Filter -->
                            <div>
                                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <i class="fas fa-search text-gray-400"></i>
                                    </div>
                                    <input type="text" class="w-full pl-10 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" id="search" name="search" value="{{ request('search') }}" placeholder="Order number or customer name">
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-end space-x-3 mt-4">
                            <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-black font-medium rounded-md transition duration-150 ease-in-out">
                                <i class="fas fa-undo mr-2"></i> Reset
                            </a>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-md transition duration-150 ease-in-out shadow-sm">
                                <i class="fas fa-filter mr-2"></i> Apply Filters
                            </button>
                        </div>
                    </form>
                </div>

                <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative">
                    <table class="min-w-full divide-y divide-gray-200" id="ordersTable">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order #</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Shipping Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($orders as $order)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $order->order_number }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <a href="{{ route('admin.users.show', $order->user) }}" class="text-indigo-600 hover:text-indigo-900">
                                        {{ $order->user->name }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->formatted_total_amount }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">{!! $order->status_badge !!}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">{!! $order->shipping_status_badge !!}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->created_at->format('M d, Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>
                                    <a href="{{ route('admin.orders.edit', $order) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-10 text-center text-gray-500">
                                    <span class="text-gray-400 text-sm">No orders found</span>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Make table headers sortable
        const tableHeaders = document.querySelectorAll('#ordersTable th');
        tableHeaders.forEach(header => {
            header.style.cursor = 'pointer';
            header.addEventListener('mouseover', function() {
                this.classList.add('text-indigo-700');
            });
            header.addEventListener('mouseout', function() {
                this.classList.remove('text-indigo-700');
            });

            header.addEventListener('click', function() {
                const index = Array.from(this.parentNode.children).indexOf(this);
                const currentUrl = new URL(window.location.href);
                const sort = currentUrl.searchParams.get('sort') === 'asc' ? 'desc' : 'asc';
                currentUrl.searchParams.set('sort', sort);
                currentUrl.searchParams.set('column', index);
                window.location.href = currentUrl.toString();
            });
        });

        // Refresh button handler
        const refreshButton = document.getElementById('refreshTable');
        if (refreshButton) {
            refreshButton.addEventListener('click', function() {
                this.innerHTML = '<i class="fas fa-sync-alt mr-1.5 text-sm fa-spin"></i> Refreshing...';
                const baseUrl = window.location.href.split('?')[0];
                window.location.href = baseUrl;
            });
        }

        // Export dropdown toggle
        const exportButton = document.getElementById('exportDropdownButton');
        const exportMenu = document.getElementById('exportDropdownMenu');
        if (exportButton && exportMenu) {
            exportButton.addEventListener('click', function(e) {
                e.stopPropagation();
                exportMenu.classList.toggle('hidden');
                this.classList.toggle('active');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.closest('#exportDropdownContainer')) {
                    exportMenu.classList.add('hidden');
                    exportButton.classList.remove('active');
                }
            });

            // Export handlers
            const exportOptions = document.querySelectorAll('[data-export-type]');
            exportOptions.forEach(option => {
                option.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    const exportType = this.getAttribute('data-export-type');

                    // Show loading indicator
                    const originalText = exportButton.innerHTML;
                    exportButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-1.5 text-sm"></i> Exporting...';

                    // Hide dropdown after selection
                    exportMenu.classList.add('hidden');
                    exportButton.classList.remove('active');

                    // Implement export functionality based on type
                    alert('Export to ' + exportType + ' will be implemented soon.');

                    // Restore button text after a delay
                    setTimeout(function() {
                        exportButton.innerHTML = originalText;
                    }, 2000);
                });
            });
        }

        // Date range picker initialization
        const dateInputs = document.querySelectorAll('input[type="date"]');
        dateInputs.forEach(input => {
            input.addEventListener('change', function() {
                const fromDate = document.getElementById('from_date').value;
                const toDate = document.getElementById('to_date').value;
                if ((fromDate && toDate) || (!fromDate && !toDate)) {
                    this.form.submit();
                }
            });
        });
    });
</script>

<style>
    /* Custom dropdown styles */
    #exportDropdownMenu {
        display: block;
    }
    #exportDropdownMenu.hidden {
        display: none;
    }
    .export-option:hover i {
        transform: translateX(2px);
        transition: transform 0.2s ease;
    }
    #exportDropdownButton.active {
        background-color: #f3f4f6;
        border-color: #d1d5db;
    }
</style>
@endsection
