<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Mobile's Nest</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Static Gradient Background -->
        <style>
            .gradient-background {
                background: linear-gradient(135deg, #000000 0%, #2563EB 50%, #ffffff 100%);
            }
        </style>
    </head>
    <body class="font-sans antialiased gradient-background">
        <div class="bg-black/40 min-h-screen">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Header -->
                <header class="py-8">
                    <div class="flex items-center justify-between">
                        <div class="flex-1"></div>
                        <div class="flex items-center gap-6">
                            <img src="{{ asset('images/mnlogo.png') }}" 
                                alt="Mobile's Nest Logo" 
                                class="h-16 w-auto transition-transform hover:scale-110"/>
                            <h1 class="text-4xl font-bold text-white">Mobile's Nest</h1>
                        </div>
                        
                        <div class="flex-1 flex justify-end">
                            @if (Route::has('login'))
                                <nav class="space-x-4">
                                    @auth
                                        <a href="{{ url('/dashboard') }}"
                                            class="inline-flex items-center px-4 py-2 text-white border border-white/20 rounded-lg hover:bg-white/10 transition-colors duration-200">
                                            Dashboard
                                        </a>
                                    @else
                                        <a href="{{ route('login') }}"
                                            class="inline-flex items-center px-4 py-2 text-white border border-white/20 rounded-lg hover:bg-white/10 transition-colors duration-200">
                                            Log in
                                        </a>

                                        @if (Route::has('register'))
                                            <a href="{{ route('register') }}"
                                                class="inline-flex items-center px-4 py-2 text-white bg-[#2563EB] rounded-lg hover:bg-[#2563EB]/90 transition-colors duration-200">
                                                Register
                                            </a>
                                        @endif
                                    @endauth
                                </nav>
                            @endif
                        </div>
                    </div>
                </header>

                <!-- Main Content -->
                <main class="py-12">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Welcome Card -->
                        <div class="flex flex-col items-center justify-center p-6 bg-white/10 backdrop-blur-sm rounded-lg shadow-lg border border-white/20">
                            <h2 class="text-2xl font-bold text-white mb-4">Welcome to Mobile's Nest</h2>
                            <p class="text-white/80 text-lg leading-relaxed">
                                Your one-stop destination for mobile device management and tracking.
                            </p>
                        </div>

                        <!-- Feature Cards -->
                        <div class="space-y-8">
                            <div class="flex flex-col items-center justify-center p-6 bg-white/10 backdrop-blur-sm rounded-lg shadow-lg border border-white/20">
                                <div class="flex size-16 items-center justify-center rounded-full bg-[#2563EB]/20 mb-4">
                                    <svg class="size-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <h2 class="text-xl font-semibold text-white">Track Your Devices</h2>
                                <p class="mt-4 text-center text-white/80">
                                    Keep track of all your mobile devices in one secure location.
                                </p>
                            </div>

                            
                            <div class="flex flex-col items-center justify-center p-6 bg-white/10 backdrop-blur-sm rounded-lg shadow-lg border border-white/20">
                                <div class="flex size-16 items-center justify-center rounded-full bg-[#2563EB]/20 mb-4">
                                    <svg class="size-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                                <h2 class="text-xl font-semibold text-white">Secure Management</h2>
                                <p class="mt-4 text-center text-white/80">
                                    Advanced security features to protect your device information.
                                </p>
                            </div>

                            <div class="flex flex-col items-center justify-center p-6 bg-white/10 backdrop-blur-sm rounded-lg shadow-lg border border-white/20">
                                <div class="flex size-16 items-center justify-center rounded-full bg-[#2563EB]/20 mb-4">
                                    <svg class="size-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                                <h2 class="text-xl font-semibold text-white">Easy Inventory</h2>
                                <p class="mt-4 text-center text-white/80">
                                    Manage your mobile device inventory with ease and efficiency.
                                </p>
                            </div>
                        </div>
                    </div>
                </main>

                <!-- Footer -->
                <footer class="py-8 text-center">
                    <p class="text-white/70">
                        Mobile's Nest &copy; {{ date('Y') }} | All rights reserved
                    </p>
                </footer>
            </div>
        </div>
    </body>
</html>
