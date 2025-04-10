<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard') - {{ config('app.name', 'MobilesNest') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Additional Styles -->
    <style>
        .sidebar-item {
            @apply flex items-center p-3 text-gray-700 rounded-lg transition-all duration-200 hover:bg-indigo-50 hover:text-indigo-700;
        }
        .sidebar-item.active {
            @apply bg-indigo-50 text-indigo-700 font-medium;
        }
        .sidebar-icon {
            @apply w-5 h-5 mr-3 text-gray-500 transition-colors duration-200;
        }
        .sidebar-item.active .sidebar-icon {
            @apply text-indigo-600;
        }
        .sidebar-item:hover .sidebar-icon {
            @apply text-indigo-600;
        }
        .stat-card {
            @apply bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden border border-gray-100;
        }
        .stat-icon-container {
            @apply p-3 rounded-full;
        }
        .dashboard-section {
            @apply bg-white rounded-xl shadow-sm p-6 border border-gray-100;
        }
        .dashboard-table {
            @apply min-w-full divide-y divide-gray-200;
        }
        .dashboard-table th {
            @apply px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider;
        }
        .dashboard-table td {
            @apply px-6 py-4 whitespace-nowrap text-sm text-gray-500;
        }
        .dashboard-table tr {
            @apply hover:bg-gray-50 transition-colors duration-150;
        }
        .btn-primary {
            @apply inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150;
        }
        .btn-secondary {
            @apply inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150;
        }
        .btn-success {
            @apply inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150;
        }
        .btn-danger {
            @apply inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150;
        }
        .badge {
            @apply inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium;
        }
        .badge-success {
            @apply bg-green-100 text-green-800;
        }
        .badge-warning {
            @apply bg-yellow-100 text-yellow-800;
        }
        .badge-danger {
            @apply bg-red-100 text-red-800;
        }
        .badge-info {
            @apply bg-blue-100 text-blue-800;
        }
        .form-input {
            @apply mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50;
        }
        .form-label {
            @apply block text-sm font-medium text-gray-700 mb-1;
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <!-- Page Content -->
        <div class="flex flex-col md:flex-row min-h-screen bg-gray-100">
            <!-- Sidebar -->
            <div class="w-full md:w-64 bg-white shadow-md md:min-h-screen">
                <div class="p-4 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800">Admin Panel</h2>
                </div>
                <nav class="p-4">
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-100 text-blue-700' : '' }}">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.users.index') }}" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100 {{ request()->routeIs('admin.users.*') ? 'bg-blue-100 text-blue-700' : '' }}">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                User Management
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.products.index') }}" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100 {{ request()->routeIs('admin.products.*') ? 'bg-blue-100 text-blue-700' : '' }}">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                Product Management
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.phones.index') }}" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100 {{ request()->routeIs('admin.phones.*') ? 'bg-blue-100 text-blue-700' : '' }}">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                                Phone Management
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.orders.index') }}" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100 {{ request()->routeIs('admin.orders.*') ? 'bg-blue-100 text-blue-700' : '' }}">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                </svg>
                                Order Management
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.inventory.index') }}" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100 {{ request()->routeIs('admin.inventory.*') ? 'bg-blue-100 text-blue-700' : '' }}">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                </svg>
                                Inventory Management
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.transactions.index') }}" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-gray-100 {{ request()->routeIs('admin.transactions.*') ? 'bg-blue-100 text-blue-700' : '' }}">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                Transactions
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="flex-1 p-6 md:p-8 overflow-hidden">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Additional Scripts -->
    @stack('scripts')
</body>
</html>
