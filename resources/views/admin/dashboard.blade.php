@extends('admin.layouts.app')

@section('admin-content')
<div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if (session('status'))
            <div class="mb-6 px-4 py-3 bg-blue-50 border-l-4 border-blue-500 text-blue-800 rounded-r-md shadow-sm" role="alert">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium">{{ session('status') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <h1 class="heading-xl mb-8">Admin Dashboard</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="stat-card group">
                <div class="flex items-center">
                    <div class="stat-icon-container">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Users</p>
                        <p class="text-2xl font-semibold text-gray-900 group-hover:text-blue-700 transition-colors duration-300">{{ App\Models\User::count() }}</p>
                    </div>
                </div>
            </div>

            <div class="stat-card group">
                <div class="flex items-center">
                    <div class="stat-icon-container">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Products</p>
                        <p class="text-2xl font-semibold text-gray-900 group-hover:text-blue-700 transition-colors duration-300">{{ App\Models\Phone::count() }}</p>
                    </div>
                </div>
            </div>

            <div class="stat-card group">
                <div class="flex items-center">
                    <div class="stat-icon-container">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Sales</p>
                        <p class="text-2xl font-semibold text-gray-900 group-hover:text-blue-700 transition-colors duration-300">{{ App\Models\Transaction::count() }}</p>
                    </div>
                </div>
            </div>

            <div class="stat-card group">
                <div class="flex items-center">
                    <div class="stat-icon-container">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Low Stock</p>
                        <p class="text-2xl font-semibold text-gray-900 group-hover:text-blue-700 transition-colors duration-300">{{ App\Models\Phone::where('stock', '<', 5)->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Transactions -->
        <div class="content-section mb-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="heading-md">Recent Transactions</h2>
                <a href="{{ route('admin.transactions.index') }}" class="text-sm text-blue-600 hover:text-blue-800 flex items-center bg-blue-50 px-3 py-1 rounded-full transition-colors duration-200">
                    View All
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            <div class="divider"></div>

            @if(isset($recentTransactions) && !empty($recentTransactions))
                <div class="table-container overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-blue-50">
                            <tr>
                                <th class="table-header">ID</th>
                                <th class="table-header">Customer</th>
                                <th class="table-header">Amount</th>
                                <th class="table-header">Status</th>
                                <th class="table-header">Date</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($recentTransactions as $transaction)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="table-cell font-medium">
                                        <a href="{{ route('admin.transactions.show', $transaction) }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                            {{ $transaction->transaction_number }}
                                        </a>
                                    </td>
                                    <td class="table-cell">
                                        {{ $transaction->order->user->name }}
                                    </td>
                                    <td class="table-cell font-medium">
                                        {{ $transaction->formatted_amount }}
                                    </td>
                                    <td class="table-cell">
                                        {!! $transaction->status_badge !!}
                                    </td>
                                    <td class="table-cell">
                                        {{ $transaction->created_at->format('M d, Y') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="card-flat text-center py-8">
                    <div class="bg-blue-50 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <p class="text-gray-600">No recent transactions found.</p>
                </div>
            @endif
        </div>

        <!-- Quick Actions -->
        <div class="content-section">
            <h2 class="heading-md mb-6">Quick Actions</h2>
            <div class="divider"></div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-6">
                <a href="{{ route('admin.phones.create') }}" class="card-flat flex items-center p-4 hover:bg-blue-50 transition-colors duration-200 group">
                    <div class="bg-blue-100 p-3 rounded-full text-blue-600 group-hover:bg-blue-200 transition-colors duration-200">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>
                    <span class="ml-3 text-gray-800 group-hover:text-blue-700 transition-colors duration-200">Add New Product</span>
                </a>
                <a href="{{ route('admin.users.create') }}" class="card-flat flex items-center p-4 hover:bg-blue-50 transition-colors duration-200 group">
                    <div class="bg-blue-100 p-3 rounded-full text-blue-600 group-hover:bg-blue-200 transition-colors duration-200">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                    </div>
                    <span class="ml-3 text-gray-800 group-hover:text-blue-700 transition-colors duration-200">Add New User</span>
                </a>
                <a href="{{ route('admin.inventory.low-stock') }}" class="card-flat flex items-center p-4 hover:bg-blue-50 transition-colors duration-200 group">
                    <div class="bg-blue-100 p-3 rounded-full text-blue-600 group-hover:bg-blue-200 transition-colors duration-200">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                    </div>
                    <span class="ml-3 text-gray-800 group-hover:text-blue-700 transition-colors duration-200">View Low Stock</span>
                </a>
                <a href="{{ route('admin.transactions.index') }}" class="card-flat flex items-center p-4 hover:bg-blue-50 transition-colors duration-200 group">
                    <div class="bg-blue-100 p-3 rounded-full text-blue-600 group-hover:bg-blue-200 transition-colors duration-200">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                    </div>
                    <span class="ml-3 text-gray-800 group-hover:text-blue-700 transition-colors duration-200">View Transactions</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection