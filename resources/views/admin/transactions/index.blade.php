@extends('layouts.admin')

@section('title', 'Transactions')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Transactions</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Transactions</li>
    </ol>
    
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @include('admin.transactions._filters')
    
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-table me-1"></i>
                Transactions List
            </div>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-outline-secondary" id="refreshTable">
                    <i class="fas fa-sync-alt me-1"></i> Refresh
                </button>
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-download me-1"></i> Export
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="exportDropdown">
                        <li><a class="dropdown-item" href="#" data-export-type="csv">CSV</a></li>
                        <li><a class="dropdown-item" href="#" data-export-type="excel">Excel</a></li>
                        <li><a class="dropdown-item" href="#" data-export-type="pdf">PDF</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="transactionsTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Transaction Number</th>
                            <th>Order Number</th>
                            <th>Customer</th>
                            <th>Amount</th>
                            <th>Payment Method</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->id }}</td>
                                <td>{{ $transaction->transaction_number }}</td>
                                <td>{{ $transaction->order->order_number }}</td>
                                <td>{{ $transaction->order->user->name }}</td>
                                <td>{{ $transaction->formatted_amount }}</td>
                                <td>{{ ucfirst($transaction->payment_method) }}</td>
                                <td>{!! $transaction->status_badge !!}</td>
                                <td>{{ $transaction->created_at->format('M d, Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('admin.transactions.show', $transaction) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $transactions->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Initialize sorting functionality
        const table = $('#transactionsTable').on('click', 'th', function() {
            const index = $(this).index();
            const currentUrl = new URL(window.location.href);
            const sort = currentUrl.searchParams.get('sort') === 'asc' ? 'desc' : 'asc';
            currentUrl.searchParams.set('sort', sort);
            currentUrl.searchParams.set('column', index);
            window.location.href = currentUrl.toString();
        });

        // Refresh button handler
        $('#refreshTable').on('click', function() {
            window.location.reload();
        });

        // Export handlers
        $('[data-export-type]').on('click', function(e) {
            e.preventDefault();
            const exportType = $(this).data('export-type');
            // Implement export functionality based on type
            console.log('Export to:', exportType);
        });

        // Date range picker initialization
        $('input[type="date"]').on('change', function() {
            this.form.submit();
        });}
    });
</script>
@endsection