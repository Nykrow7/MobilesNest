@extends('layouts.admin')

@section('title', 'Orders')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Orders</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-indigo-600 hover:text-indigo-800">Dashboard</a></li>
                <li class="breadcrumb-item active text-gray-500">Orders</li>
            </ol>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium py-2 px-4 rounded-lg shadow-sm transition duration-150 ease-in-out" id="refreshTable">
                <i class="fas fa-sync-alt me-2"></i> Refresh
            </button>
            <div class="dropdown">
                <button class="btn bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium py-2 px-4 rounded-lg shadow-sm transition duration-150 ease-in-out dropdown-toggle" type="button" id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-download me-2"></i> Export
                </button>
                <ul class="dropdown-menu shadow-lg border-0 rounded-lg py-2" aria-labelledby="exportDropdown">
                    <li><a class="dropdown-item hover:bg-gray-100 py-2 px-4" href="#" data-export-type="csv"><i class="fas fa-file-csv me-2 text-green-600"></i> CSV</a></li>
                    <li><a class="dropdown-item hover:bg-gray-100 py-2 px-4" href="#" data-export-type="excel"><i class="fas fa-file-excel me-2 text-green-600"></i> Excel</a></li>
                    <li><a class="dropdown-item hover:bg-gray-100 py-2 px-4" href="#" data-export-type="pdf"><i class="fas fa-file-pdf me-2 text-red-600"></i> PDF</a></li>
                </ul>
            </div>
        </div>
    </div>

    @if(session('success'))
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
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 text-indigo-700 font-medium"><i class="fas fa-filter me-2"></i>Filter Orders</h5>
        </div>
        <div class="card-body bg-white">
            <form action="{{ route('admin.orders.index') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label for="status" class="form-label text-gray-600 text-sm font-medium">Order Status</label>
                    <select name="status" id="status" class="form-select shadow-sm border-gray-300 rounded-lg focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Statuses</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="from_date" class="form-label text-gray-600 text-sm font-medium">From Date</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-calendar-alt text-gray-400"></i>
                        </div>
                        <input type="date" class="form-control pl-10 shadow-sm border-gray-300 rounded-lg focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" id="from_date" name="from_date" value="{{ request('from_date') }}">
                    </div>
                </div>

                <div class="col-md-3">
                    <label for="to_date" class="form-label text-gray-600 text-sm font-medium">To Date</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-calendar-alt text-gray-400"></i>
                        </div>
                        <input type="date" class="form-control pl-10 shadow-sm border-gray-300 rounded-lg focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" id="to_date" name="to_date" value="{{ request('to_date') }}">
                    </div>
                </div>

                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition duration-150 ease-in-out shadow-sm me-2">
                        <i class="fas fa-filter me-2"></i> Apply Filters
                    </button>
                    <a href="{{ route('admin.orders.index') }}" class="btn bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-2 px-4 rounded-lg transition duration-150 ease-in-out">
                        <i class="fas fa-undo me-2"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card mb-4 shadow-sm border-0 overflow-hidden">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <div class="text-indigo-700 font-medium">
                <i class="fas fa-shopping-cart me-2"></i>
                Orders List
            </div>
            <div class="text-sm text-gray-500">
                Total: <span class="font-medium">{{ $orders->total() }}</span> orders
            </div>
        </div>
        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table table-hover" id="ordersTable" width="100%" cellspacing="0">
                    <thead class="bg-gray-50 text-gray-600 text-sm">
                        <tr>
                            <th class="py-3 px-4 font-medium">Order #</th>
                            <th class="py-3 px-4 font-medium">Customer</th>
                            <th class="py-3 px-4 font-medium">Total</th>
                            <th class="py-3 px-4 font-medium">Status</th>
                            <th class="py-3 px-4 font-medium">Shipping Status</th>
                            <th class="py-3 px-4 font-medium">Date</th>
                            <th class="py-3 px-4 font-medium">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($orders as $order)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="py-3 px-4 font-medium text-gray-900">{{ $order->order_number }}</td>
                                <td class="py-3 px-4">
                                    <a href="{{ route('admin.users.show', $order->user) }}" class="text-gray-700 hover:text-indigo-600">
                                        {{ $order->user->name }}
                                    </a>
                                </td>
                                <td class="py-3 px-4 font-medium">{{ $order->formatted_total_amount }}</td>
                                <td class="py-3 px-4">{!! $order->status_badge !!}</td>
                                <td class="py-3 px-4">{!! $order->shipping_status_badge !!}</td>
                                <td class="py-3 px-4 text-gray-500">{{ $order->created_at->format('M d, Y') }}</td>
                                <td class="py-3 px-4">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.orders.show', $order) }}" class="btn bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium py-1 px-3 rounded-lg transition duration-150 ease-in-out shadow-sm" data-bs-toggle="tooltip" title="View Order Details">
                                            <i class="fas fa-eye mr-1"></i> View
                                        </a>
                                        <a href="{{ route('admin.orders.edit', $order) }}" class="btn bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-1 px-3 rounded-lg transition duration-150 ease-in-out shadow-sm" data-bs-toggle="tooltip" title="Edit Order">
                                            <i class="fas fa-edit mr-1"></i> Edit
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-6 text-center text-gray-500">No orders found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-4 py-3 border-t border-gray-200">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // Make table headers sortable
        $('#ordersTable th').css('cursor', 'pointer').hover(function() {
            $(this).addClass('text-indigo-700');
        }, function() {
            $(this).removeClass('text-indigo-700');
        });

        // Initialize sorting functionality
        $('#ordersTable').on('click', 'th', function() {
            const index = $(this).index();
            const currentUrl = new URL(window.location.href);
            const sort = currentUrl.searchParams.get('sort') === 'asc' ? 'desc' : 'asc';
            currentUrl.searchParams.set('sort', sort);
            currentUrl.searchParams.set('column', index);
            window.location.href = currentUrl.toString();
        });

        // Refresh button handler
        $('#refreshTable').on('click', function() {
            $(this).html('<i class="fas fa-sync-alt me-2 fa-spin"></i> Refreshing...');
            window.location.reload();
        });

        // Export handlers
        $('[data-export-type]').on('click', function(e) {
            e.preventDefault();
            const exportType = $(this).data('export-type');
            // Implement export functionality based on type
            alert('Export to ' + exportType + ' will be implemented soon.');
        });

        // Date range picker initialization
        $('input[type="date"]').on('change', function() {
            // Only submit if both dates are filled or both are empty
            const fromDate = $('#from_date').val();
            const toDate = $('#to_date').val();
            if ((fromDate && toDate) || (!fromDate && !toDate)) {
                this.form.submit();
            }
        });

        // Add tooltips to action buttons
        $('[data-bs-toggle="tooltip"]').tooltip();
    });
</script>
@endpush
@endsection
