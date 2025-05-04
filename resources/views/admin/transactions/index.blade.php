@extends('layouts.admin')

@section('title', 'Transactions')

@section('styles')
<style>
    /* Custom dropdown styles */
    #exportDropdownMenu {
        display: block;
        border: 1px solid #e5e7eb;
    }
    #exportDropdownMenu.hidden {
        display: none;
    }
    .export-option {
        cursor: pointer;
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

@section('content')
<div class="container-fluid px-4">
    <!-- Page Header -->
    <div class="flex justify-between items-center mt-6 mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-black">Transactions</h1>
            <nav class="flex mt-2" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-indigo-600">
                            <i class="fas fa-home mr-2"></i>Dashboard
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs"></i>
                            <span class="text-gray-500">Transactions</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
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
                        <a class="export-option block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-indigo-600 transition-colors duration-150" href="{{ route('admin.transactions.export', ['type' => 'csv']) }}{{ request()->getQueryString() ? '?' . request()->getQueryString() : '' }}" data-export-type="csv"><i class="fas fa-file-csv mr-2 text-green-600"></i> CSV</a>
                        <a class="export-option block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-indigo-600 transition-colors duration-150" href="{{ route('admin.transactions.export', ['type' => 'excel']) }}{{ request()->getQueryString() ? '?' . request()->getQueryString() : '' }}" data-export-type="excel"><i class="fas fa-file-excel mr-2 text-green-600"></i> Excel</a>
                        <a class="export-option block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-indigo-600 transition-colors duration-150" href="{{ route('admin.transactions.export', ['type' => 'pdf']) }}{{ request()->getQueryString() ? '?' . request()->getQueryString() : '' }}" data-export-type="pdf"><i class="fas fa-file-pdf mr-2 text-red-600"></i> PDF</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Alert -->
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md" role="alert">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                </div>
                <div>
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Filters Section -->
    @include('admin.transactions._filters')

    <!-- Transactions Table -->
    <div class="bg-white rounded-md shadow-sm border border-gray-200 overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <div class="text-black font-medium flex items-center">
                <i class="fas fa-table mr-2"></i>
                Transactions List
            </div>
            <div class="text-sm text-gray-600">
                Total: <span class="font-medium">{{ $transactions->total() }}</span> transactions
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200" id="transactionsTable">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">ID</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">Transaction Number</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">Order Number</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">Customer</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">Amount</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">Payment Method</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">Date</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-black uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($transactions as $transaction)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $transaction->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-black">{{ $transaction->transaction_number }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="{{ route('admin.orders.show', $transaction->order) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">
                                    {{ $transaction->order->order_number }}
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="{{ route('admin.users.show', $transaction->order->user) }}" class="text-gray-700 hover:text-indigo-600">
                                    {{ $transaction->order->user->name }}
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-black">{{ $transaction->formatted_amount }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($transaction->payment_method == 'credit_card')
                                    <span class="inline-flex items-center">
                                        <i class="far fa-credit-card text-blue-500 mr-2"></i>
                                        Credit Card
                                    </span>
                                @elseif($transaction->payment_method == 'paypal')
                                    <span class="inline-flex items-center">
                                        <i class="fab fa-paypal text-blue-600 mr-2"></i>
                                        PayPal
                                    </span>
                                @elseif($transaction->payment_method == 'bank_transfer')
                                    <span class="inline-flex items-center">
                                        <i class="fas fa-university text-gray-600 mr-2"></i>
                                        Bank Transfer
                                    </span>
                                @else
                                    {{ ucfirst($transaction->payment_method) }}
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">{!! $transaction->status_badge !!}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $transaction->created_at->format('M d, Y H:i') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.transactions.show', $transaction) }}" class="inline-flex items-center px-3 py-1 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" data-bs-toggle="tooltip" title="View Transaction Details">
                                    <i class="fas fa-eye mr-1"></i> View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $transactions->links() }}
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Make table headers sortable
        $('#transactionsTable th').css('cursor', 'pointer').hover(function() {
            $(this).addClass('text-indigo-700');
        }, function() {
            $(this).removeClass('text-indigo-700');
        });

        // Initialize sorting functionality
        $('#transactionsTable').on('click', 'th', function() {
            const index = $(this).index();
            const currentUrl = new URL(window.location.href);
            const sort = currentUrl.searchParams.get('sort') === 'asc' ? 'desc' : 'asc';
            currentUrl.searchParams.set('sort', sort);
            currentUrl.searchParams.set('column', index);
            window.location.href = currentUrl.toString();
        });

        // Refresh button handler
        $('#refreshTable').on('click', function() {
            $(this).html('<i class="fas fa-sync-alt mr-1.5 text-sm fa-spin"></i> Refreshing...');

            // Get current URL without query parameters
            const baseUrl = window.location.href.split('?')[0];

            // Redirect to the base URL to reset all filters
            window.location.href = baseUrl;
        });

        // Export dropdown toggle
        $('#exportDropdownButton').on('click', function(e) {
            e.stopPropagation();
            $('#exportDropdownMenu').toggleClass('hidden');
            $(this).toggleClass('active');
        });

        // Close dropdown when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('#exportDropdownContainer').length) {
                $('#exportDropdownMenu').addClass('hidden');
                $('#exportDropdownButton').removeClass('active');
            }
        });

        // Export handlers
        $('[data-export-type]').on('click', function(e) {
            // Don't prevent default - let the link work
            e.stopPropagation();
            const exportType = $(this).data('export-type');

            // Show loading indicator
            const originalText = $('#exportDropdownButton').html();
            $('#exportDropdownButton').html('<i class="fas fa-spinner fa-spin mr-1.5 text-sm"></i> Exporting...');

            // Hide dropdown after selection
            $('#exportDropdownMenu').addClass('hidden');
            $('#exportDropdownButton').removeClass('active');

            // Restore button text after a delay
            setTimeout(function() {
                $('#exportDropdownButton').html(originalText);
            }, 2000);
        });

        // Date range picker initialization
        $('input[type="date"]').on('change', function() {
            this.form.submit();
        });

        // Add tooltips to action buttons
        $('[data-bs-toggle="tooltip"]').tooltip();
    });
</script>
@endsection