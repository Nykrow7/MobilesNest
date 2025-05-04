<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Verify Email - Mobile's Nest</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            .gradient-background {
                background: linear-gradient(135deg, #000000 0%, #333333 50%, #ffffff 100%);
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen gradient-background">
            <div class="bg-black/30 min-h-screen">
                <!-- Header -->
                <header class="py-8">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="flex items-center justify-between">
                            <a href="{{ route('welcome') }}" class="flex items-center">
                                <img src="{{ asset('images/mnlogo_original.png') }}" alt="Mobile's Nest Logo" class="h-10 w-auto">
                                <span class="ml-3 text-xl font-bold text-white">Mobile's Nest</span>
                            </a>
                        </div>
                    </div>
                </header>

                <!-- Verify Email Form Section -->
                <div class="flex justify-center items-center py-12">
                    <div class="w-full max-w-xl bg-white/10 backdrop-blur-md shadow-2xl rounded-2xl p-12 border border-white/20">
                        <!-- Form Header -->
                        <div class="text-center mb-10">
                            <h2 class="text-2xl font-bold text-white mb-2">Verify Your Email</h2>
                            <p class="text-white/70">One more step to complete your registration</p>
                        </div>

                        <div class="mb-6 bg-white/5 border border-white/10 rounded-lg p-4 text-white/80 text-sm">
                            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                        </div>

                        @if (session('status') == 'verification-link-sent')
                            <div class="mb-6 bg-green-900/20 border border-green-500/30 rounded-lg p-4 flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-400 mr-2 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-green-400 text-sm">
                                    {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                                </span>
                            </div>
                        @endif

                        <div class="mt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
                            <form method="POST" action="{{ route('verification.send') }}" class="w-full sm:w-auto">
                                @csrf
                                <button type="submit" class="w-full sm:w-auto bg-primary-800 hover:bg-primary-700 text-white font-medium py-3 px-6 rounded-lg transition duration-200 flex items-center justify-center shadow-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    {{ __('Resend Verification Email') }}
                                </button>
                            </form>

                            <form method="POST" action="{{ route('logout') }}" class="w-full sm:w-auto">
                                @csrf
                                <button type="submit" class="w-full sm:w-auto bg-white/10 hover:bg-white/20 text-white font-medium py-3 px-6 rounded-lg transition duration-200 flex items-center justify-center border border-white/20">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    {{ __('Log Out') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <footer class="py-8 text-center">
                    <div class="flex flex-col items-center">
                        <div class="flex items-center mb-3">
                            <img src="{{ asset('images/mnlogo_original.png') }}" alt="Mobile's Nest Logo" class="h-8 w-auto mr-2">
                            <span class="text-white font-medium">Mobile's Nest</span>
                        </div>
                        <p class="text-white/70">
                            &copy; {{ date('Y') }} Mobile's Nest | All rights reserved
                        </p>
                    </div>
                </footer>
            </div>
        </div>
    </body>
</html>
