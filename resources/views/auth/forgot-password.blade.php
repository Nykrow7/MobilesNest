<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Forgot Password - Mobile's Nest</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            .gradient-background {
                background: linear-gradient(135deg, #000000 0%, #2563EB 50%, #ffffff 100%);
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen gradient-background">
            <div class="bg-black/40 min-h-screen">
                <!-- Header -->
                <header class="py-8">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="flex items-center justify-between">
                            <div class="flex-1"></div>
                            <div class="flex items-center gap-6">
                                <img src="{{ asset('images/mnlogo_original.png') }}"
                                    alt="Mobile's Nest Logo"
                                    class="h-16 w-auto transition-transform hover:scale-110"/>
                                <h1 class="text-4xl font-bold text-white">Mobile's Nest</h1>
                            </div>
                            <div class="flex-1"></div>
                        </div>
                    </div>
                </header>

                <!-- Forgot Password Form Section -->
                <div class="flex justify-center items-center py-12">
                    <div class="w-full max-w-xl bg-black/50 backdrop-blur-md shadow-2xl rounded-2xl p-12">
                        <!-- Form Header -->
                        <div class="text-center mb-10">
                            <h2 class="text-2xl font-bold text-white mb-2">Forgot Your Password?</h2>
                            <p class="text-white/70">No problem. Just let us know your email address and we will email you a password reset link.</p>
                        </div>

                        <!-- Session Status -->
                        @if (session('status'))
                            <div class="mb-4 text-sm text-green-500">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}" class="space-y-8">
                            @csrf

                            <!-- Email Address -->
                            <div>
                                <x-input-label for="email" :value="__('Email')" class="text-white text-lg mb-2" />
                                <x-text-input id="email"
                                    class="block w-full p-4 bg-white/5 border-0 text-white placeholder-white/30 rounded-lg focus:ring-2 focus:ring-blue-500 transition-all"
                                    type="email"
                                    name="email"
                                    :value="old('email')"
                                    placeholder="Enter your email"
                                    required
                                    autofocus />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Submit Button -->
                            <div class="mt-10">
                                <x-primary-button class="w-full justify-center py-4 bg-blue-600 hover:bg-blue-500 transition-colors duration-200 text-lg font-semibold rounded-lg">
                                    {{ __('Email Password Reset Link') }}
                                </x-primary-button>
                            </div>

                            <!-- Alternative Options -->
                            <div class="text-center mt-8">
                                <div class="mb-4">
                                    <a href="{{ route('password.security.request') }}" class="text-blue-400 hover:text-blue-300 transition-colors">
                                        {{ __('Reset with Security Question Instead') }}
                                    </a>
                                </div>
                                <div>
                                    <a href="{{ route('login') }}" class="text-blue-400 hover:text-blue-300 transition-colors">
                                        {{ __('Back to Login') }}
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

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
