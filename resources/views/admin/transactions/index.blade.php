@extends('layouts.admin')

@section('title', 'Transactions')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Transactions</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-indigo-600 hover:text-indigo-800">Dashboard</a></li>
                <li class="breadcrumb-item active text-gray-500">Transactions</li>
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

    @include('admin.transactions._filters')

    <div class="card mb-4 shadow-sm border-0 overflow-hidden">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <div class="text-indigo-700 font-medium">
                <i class="fas fa-table me-2"></i>
                Transactions List
            </div>
            <div class="text-sm text-gray-500">
                Total: <span class="font-medium">{{ $transactions->total() }}</span> transactions
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover" id="transactionsTable" width="100%" cellspacing="0">
                    <thead class="bg-gray-50 text-gray-600 text-sm">
                        <tr>
                            <th class="py-3 px-4 font-medium">ID</th>
                            <th class="py-3 px-4 font-medium">Transaction Number</th>
                            <th class="py-3 px-4 font-medium">Order Number</th>
                            <th class="py-3 px-4 font-medium">Customer</th>
                            <th class="py-3 px-4 font-medium">Amount</th>
                            <th class="py-3 px-4 font-medium">Payment Method</th>
                            <th class="py-3 px-4 font-medium">Status</th>
                            <th class="py-3 px-4 font-medium">Date</th>
                            <th class="py-3 px-4 font-medium">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($transactions as $transaction)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="py-3 px-4">{{ $transaction->id }}</td>
                                <td class="py-3 px-4 font-medium text-gray-900">{{ $transaction->transaction_number }}</td>
                                <td class="py-3 px-4">
                                    <a href="{{ route('admin.orders.show', $transaction->order) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">
                                        {{ $transaction->order->order_number }}
                                    </a>
                                </td>
                                <td class="py-3 px-4">
                                    <a href="{{ route('admin.users.show', $transaction->order->user) }}" class="text-gray-700 hover:text-indigo-600">
                                        {{ $transaction->order->user->name }}
                                    </a>
                                </td>
                                <td class="py-3 px-4 font-medium">{{ $transaction->formatted_amount }}</td>
                                <td class="py-3 px-4">
                                    @if($transaction->payment_method == 'credit_card')
                                        <span class="inline-flex items-center">
                                            <i class="far fa-credit-card text-blue-500 mr-1"></i>
                                            Credit Card
                                        </span>
                                    @elseif($transaction->payment_method == 'paypal')
                                        <span class="inline-flex items-center">
                                            <i class="fab fa-paypal text-blue-600 mr-1"></i>
                                            PayPal
                                        </span>
                                    @elseif($transaction->payment_method == 'bank_transfer')
                                        <span class="inline-flex items-center">
                                            <i class="fas fa-university text-gray-600 mr-1"></i>
                                            Bank Transfer
                                        </span>
                                    @else
                                        {{ ucfirst($transaction->payment_method) }}
                                    @endif
                                </td>
                                <td class="py-3 px-4">{!! $transaction->status_badge !!}</td>
                                <td class="py-3 px-4 text-gray-500">{{ $transaction->created_at->format('M d, Y H:i') }}</td>
                                <td class="py-3 px-4">
                                    <a href="{{ route('admin.transactions.show', $transaction) }}" class="btn bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium py-1 px-3 rounded-lg transition duration-150 ease-in-out shadow-sm" data-bs-toggle="tooltip" title="View Transaction Details">
                                        <i class="fas fa-eye mr-1"></i> View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="px-4 py-3 border-t border-gray-200">
                {{ $transactions->links() }}
            </div>
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
            this.form.submit();
        });

        // Add tooltips to action buttons
        $('[data-bs-toggle="tooltip"]').tooltip();
    });
</script>
@endsection