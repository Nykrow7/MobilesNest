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
                                <img src="{{ asset('images/mnlogo.png') }}" 
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
                    <div class="w-full max-w-xl bg-black/50 backdrop-blur-md shadow-2xl rounded-2xl p-12">
                        <!-- Form Header -->
                        <div class="text-center mb-10">
                            <h2 class="text-2xl font-bold text-white mb-2">Welcome Back</h2>
                            <p class="text-white/70">Please sign in to your account</p>
                        </div>

                        @if (session('success'))
                            <div class="mb-4 text-sm text-green-600">
                                {{ session('success') }}
                            </div>
                        @endif

                        <x-auth-session-status class="mb-4" :status="session('status')" />

                        <form method="POST" action="{{ route('login') }}" class="space-y-8">
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
                                    autofocus 
                                    autocomplete="username" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Password -->
                            <div class="mt-6">
                                <x-input-label for="password" :value="__('Password')" class="text-white text-lg mb-2" />
                                <x-text-input id="password" 
                                    class="block w-full p-4 bg-white/5 border-0 text-white placeholder-white/30 rounded-lg focus:ring-2 focus:ring-blue-500 transition-all"
                                    type="password"
                                    name="password"
                                    placeholder="Enter your password"
                                    required 
                                    autocomplete="current-password" />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <!-- Remember Me -->
                            <div class="flex items-center justify-between mt-8">
                                <label for="remember_me" class="inline-flex items-center">
                                    <input id="remember_me" 
                                        type="checkbox" 
                                        class="rounded-md border-0 bg-white/5 text-blue-500 focus:ring-blue-500 w-5 h-5" 
                                        name="remember">
                                    <span class="ms-3 text-white/80">{{ __('Remember me') }}</span>
                                </label>

                                @if (Route::has('password.request'))
                                    <a class="text-blue-400 hover:text-blue-300 transition-colors" 
                                        href="{{ route('password.request') }}">
                                        {{ __('Forgot your password?') }}
                                    </a>
                                @endif
                            </div>

                            <!-- Submit Button -->
                            <div class="mt-10">
                                <x-primary-button class="w-full justify-center py-4 bg-blue-600 hover:bg-blue-500 transition-colors duration-200 text-lg font-semibold rounded-lg">
                                    {{ __('Sign in') }}
                                </x-primary-button>
                            </div>

                            <!-- Register Link -->
                            <div class="text-center mt-8">
                                <span class="text-white/70">Don't have an account?</span>
                                <a href="{{ route('register') }}" class="text-blue-400 hover:text-blue-300 transition-colors ml-1">Create account</a>
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

