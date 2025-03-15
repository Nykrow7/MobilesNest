<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Register - Mobile's Nest</title>
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

                <!-- Register Form Section -->
                <div class="flex justify-center items-center py-12">
                    <div class="w-full max-w-xl bg-black/50 backdrop-blur-md shadow-2xl rounded-2xl p-12">
                        <!-- Form Header -->
                        <div class="text-center mb-10">
                            <h2 class="text-2xl font-bold text-white mb-2">Create Account</h2>
                            <p class="text-white/70">Join Mobile's Nest today</p>
                        </div>

                        <form method="POST" action="{{ route('register') }}" class="space-y-8">
                            @csrf

                            <!-- Name -->
                            <div>
                                <x-input-label for="name" :value="__('Full Name')" class="text-white text-lg mb-2" />
                                <x-text-input id="name" 
                                    class="block w-full p-4 bg-white/5 border-0 text-white placeholder-white/30 rounded-lg focus:ring-2 focus:ring-blue-500 transition-all" 
                                    type="text" 
                                    name="name" 
                                    :value="old('name')" 
                                    placeholder="Enter your full name"
                                    required 
                                    autofocus 
                                    autocomplete="name" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Email Address -->
                            <div class="mt-6">
                                <x-input-label for="email" :value="__('Email')" class="text-white text-lg mb-2" />
                                <x-text-input id="email" 
                                    class="block w-full p-4 bg-white/5 border-0 text-white placeholder-white/30 rounded-lg focus:ring-2 focus:ring-blue-500 transition-all" 
                                    type="email" 
                                    name="email" 
                                    :value="old('email')" 
                                    placeholder="Enter your email"
                                    required 
                                    autocomplete="username" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Password Section -->
                            <div class="mt-6 space-y-6">
                                <!-- Password Input -->
                                <div>
                                    <x-input-label for="password" :value="__('Password')" class="text-white text-lg mb-2" />
                                    <x-text-input id="password" 
                                        class="block w-full p-4 bg-white/5 border-0 text-white placeholder-white/30 rounded-lg focus:ring-2 focus:ring-blue-500 transition-all"
                                        type="password"
                                        name="password"
                                        placeholder="Create a password"
                                        required 
                                        autocomplete="new-password" />
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>

                                <!-- Confirm Password Input -->
                                <div>
                                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-white text-lg mb-2" />
                                    <x-text-input id="password_confirmation" 
                                        class="block w-full p-4 bg-white/5 border-0 text-white placeholder-white/30 rounded-lg focus:ring-2 focus:ring-blue-500 transition-all"
                                        type="password"
                                        name="password_confirmation" 
                                        placeholder="Confirm your password"
                                        required 
                                        autocomplete="new-password" />
                                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                </div>

                                <!-- Password Requirements -->
                                <div class="bg-white/5 rounded-lg p-4">
                                    <p class="text-white/70 font-medium mb-2">Password Requirements:</p>
                                    <ul class="text-sm text-white/70 space-y-1 list-disc list-inside">
                                        <li>Minimum 12 characters long</li>
                                        <li>Must include uppercase and lowercase letters</li>
                                        <li>Must include at least one number</li>
                                        <li>Must include at least one special character</li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="mt-10">
                                <x-primary-button class="w-full justify-center py-4 bg-blue-600 hover:bg-blue-500 transition-colors duration-200 text-lg font-semibold rounded-lg">
                                    {{ __('Create Account') }}
                                </x-primary-button>
                            </div>

                            <!-- Login Link -->
                            <div class="text-center mt-8">
                                <span class="text-white/70">Already have an account?</span>
                                <a href="{{ route('login') }}" class="text-blue-400 hover:text-blue-300 transition-colors ml-1">Sign in</a>
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
