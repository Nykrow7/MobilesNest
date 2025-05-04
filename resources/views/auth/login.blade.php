<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login - Mobile's Nest</title>
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

                <!-- Login Form Section -->
                <div class="flex justify-center items-center py-12">
                    <div class="w-full max-w-xl bg-white/10 backdrop-blur-md shadow-2xl rounded-2xl p-12 border border-white/20">
                        <!-- Form Header -->
                        <div class="text-center mb-10">
                            <h2 class="text-2xl font-bold text-white mb-2">Welcome Back</h2>
                            <p class="text-white/70">Please sign in to your account</p>
                        </div>

                        <form method="POST" action="{{ route('login') }}" class="space-y-8">
                            @csrf

                            <!-- Email Address -->
                            <div>
                                <x-input-label for="email" :value="__('Email')" class="text-white text-lg mb-2" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white/50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <x-text-input id="email"
                                        class="block w-full p-4 pl-12 bg-white/5 border border-white/10 text-white placeholder-white/30 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all"
                                        type="email"
                                        name="email"
                                        :value="old('email')"
                                        placeholder="Enter your email"
                                        required
                                        autofocus
                                        autocomplete="username" />
                                </div>
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Password -->
                            <div class="mt-6">
                                <x-input-label for="password" :value="__('Password')" class="text-white text-lg mb-2" />
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white/50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                    </div>
                                    <x-text-input id="password"
                                        class="block w-full p-4 pl-12 bg-white/5 border border-white/10 text-white placeholder-white/30 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all"
                                        type="password"
                                        name="password"
                                        placeholder="Enter your password"
                                        required
                                        autocomplete="current-password" />
                                </div>
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <!-- Remember Me -->
                            <div class="flex items-center justify-between mt-8">
                                <label for="remember_me" class="inline-flex items-center">
                                    <input id="remember_me"
                                        type="checkbox"
                                        class="rounded-md border-0 bg-white/5 text-primary-500 focus:ring-primary-500 w-5 h-5"
                                        name="remember">
                                    <span class="ms-3 text-white/80">{{ __('Remember me') }}</span>
                                </label>

                                @if (Route::has('password.request'))
                                    <div class="flex flex-col space-y-2">
                                        <a class="text-primary-400 hover:text-primary-300 transition-colors flex items-center"
                                            href="{{ route('password.request') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                            </svg>
                                            {{ __('Forgot your password?') }}
                                        </a>
                                        <a class="text-primary-400 hover:text-primary-300 transition-colors text-sm flex items-center"
                                            href="{{ route('password.security.request') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-1 w-1 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z" />
                                            </svg>
                                            {{ __('Reset with security question') }}
                                        </a>
                                    </div>
                                @endif
                            </div>

                            <!-- Error Messages -->
                            @if ($errors->any())
                                <div class="mt-4 bg-red-900/20 border border-red-500/30 rounded-lg p-3">
                                    <div class="text-red-400 text-sm">
                                        @foreach ($errors->all() as $error)
                                            <p class="flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {{ $error }}
                                            </p>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Success Message -->
                            @if (session('success'))
                                <div class="mt-4 bg-green-900/20 border border-green-500/30 rounded-lg p-3">
                                    <div class="text-green-400 text-sm flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ session('success') }}
                                    </div>
                                </div>
                            @endif

                            <!-- Submit Button -->
                            <div class="mt-10">
                                <x-primary-button class="w-full justify-center py-4 bg-primary-800 hover:bg-primary-700 transition-colors duration-200 text-lg font-semibold rounded-lg shadow-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                    </svg>
                                    {{ __('Sign in') }}
                                </x-primary-button>
                            </div>

                            <!-- Register Link -->
                            <div class="text-center mt-8">
                                <span class="text-white/70">Don't have an account?</span>
                                <a href="{{ route('register') }}" class="text-primary-400 hover:text-primary-300 transition-colors ml-1 font-medium">Create account</a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Footer -->
                <footer class="py-8 text-center">
                    <div class="flex flex-col items-center">
                        <div class="flex items-center mb-3">
                            <img src="{{ asset('images/mnlogo_original.png') }}" alt="Mobile's Nest Logo" class="h-8 w-auto mr-2">
                            <span class="text-white font-medium">Mobile's Nest</span>
                        </div>
                        <p class="text-white/70 mb-3">
                            &copy; {{ date('Y') }} Mobile's Nest | All rights reserved
                        </p>
                        <div class="flex items-center mt-2">
                            <span class="text-xs text-white/50 mr-2">Developed by:</span>
                            <img src="{{ asset('images/mnlogo_original.png') }}" alt="Mobile's Nest Logo" class="h-6 w-auto" />
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </body>
</html>

