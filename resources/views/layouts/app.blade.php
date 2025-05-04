<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Mobile\'s Nest') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased dirty-white-bg">
        <!-- Navigation at the top -->
        @include('layouts.navigation')

        <div class="min-h-screen pt-2">

            <!-- Page Heading -->
            @isset($header)
                <header class="header-gradient shadow-sm border-b border-blue-100">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="py-8">
                <div class="page-container">
                    @if (!empty($slot))
                        {{ $slot }}
                    @else
                        @yield('content')
                    @endif
                </div>
            </main>

            <!-- Footer -->
            <footer class="header-gradient border-t border-blue-100 py-8 mt-auto">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div>
                            <h3 class="text-lg font-semibold text-blue-800 mb-4">Mobile's Nest</h3>
                            <p class="text-gray-700 text-sm">Your trusted source for quality smartphones and accessories.</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-blue-800 mb-4">Quick Links</h3>
                            <ul class="space-y-2 text-sm">
                                <li><a href="{{ route('shop.index') }}" class="text-gray-700 hover:text-blue-700 transition">Shop Phones</a></li>
                                <li><a href="{{ route('cart.index') }}" class="text-gray-700 hover:text-blue-700 transition">Cart</a></li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-blue-800 mb-4">Contact</h3>
                            <p class="text-gray-700 text-sm">Email: support@mobilesnest.com</p>
                            <p class="text-gray-700 text-sm">Phone: +63 123 456 7890</p>
                        </div>
                    </div>
                    <div class="border-t border-blue-100 mt-8 pt-6 text-center text-sm text-gray-600">
                        <div class="flex flex-col items-center justify-center">
                            <p class="mb-3">&copy; {{ date('Y') }} Mobile's Nest. All rights reserved.</p>
                            <div class="flex items-center">
                                <span class="text-xs text-gray-500 mr-2">Developed by:</span>
                                <img src="{{ asset('images/mnlogo_original.png') }}" alt="Mobile's Nest Logo" class="h-8 w-auto" />
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>

        <!-- Scripts -->
        <script>
            // Add JavaScript to handle the export dropdown
            document.addEventListener('DOMContentLoaded', function() {
                // Handle dropdown toggle
                const exportButton = document.getElementById('exportDropdownButton');
                const exportMenu = document.getElementById('exportDropdownMenu');

                if (exportButton && exportMenu) {
                    exportButton.addEventListener('click', function(e) {
                        e.stopPropagation();
                        exportMenu.classList.toggle('hidden');
                        exportButton.classList.toggle('active');
                    });

                    // Close dropdown when clicking outside
                    document.addEventListener('click', function(e) {
                        if (!exportButton.contains(e.target) && !exportMenu.contains(e.target)) {
                            exportMenu.classList.add('hidden');
                            exportButton.classList.remove('active');
                        }
                    });
                }
            });
        </script>
        @stack('scripts')
    </body>
</html>
