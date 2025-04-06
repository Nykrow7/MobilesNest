<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Forgot Password - Security Question - Mobile's Nest</title>
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

                <!-- Forgot Password Form Section -->
                <div class="flex justify-center items-center py-12">
                    <div class="w-full max-w-xl bg-black/50 backdrop-blur-md shadow-2xl rounded-2xl p-12">
                        <!-- Form Header -->
                        <div class="text-center mb-10">
                            <h2 class="text-2xl font-bold text-white mb-2">Reset Password with Security Question</h2>
                            <p class="text-white/70">Reset your password using your security question instead of email.</p>
                        </div>

                        <!-- Progress Steps -->
                        <div class="mb-8">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <span class="w-8 h-8 rounded-full {{ !session('show_security_question') && !session('show_reset_form') ? 'bg-blue-600 text-white' : 'bg-gray-200' }} flex items-center justify-center text-sm font-semibold">1</span>
                                    <span class="ml-2 text-sm font-medium {{ !session('show_security_question') && !session('show_reset_form') ? 'text-white' : 'text-gray-400' }}">Find Account</span>
                                </div>
                                <div class="flex-1 mx-4 h-0.5 {{ session('show_security_question') || session('show_reset_form') ? 'bg-blue-600' : 'bg-gray-200' }}"></div>
                                <div class="flex items-center">
                                    <span class="w-8 h-8 rounded-full {{ session('show_security_question') && !session('show_reset_form') ? 'bg-blue-600 text-white' : 'bg-gray-200' }} flex items-center justify-center text-sm font-semibold">2</span>
                                    <span class="ml-2 text-sm font-medium {{ session('show_security_question') && !session('show_reset_form') ? 'text-white' : 'text-gray-400' }}">Security Question</span>
                                </div>
                                <div class="flex-1 mx-4 h-0.5 {{ session('show_reset_form') ? 'bg-blue-600' : 'bg-gray-200' }}"></div>
                                <div class="flex items-center">
                                    <span class="w-8 h-8 rounded-full {{ session('show_reset_form') ? 'bg-blue-600 text-white' : 'bg-gray-200' }} flex items-center justify-center text-sm font-semibold">3</span>
                                    <span class="ml-2 text-sm font-medium {{ session('show_reset_form') ? 'text-white' : 'text-gray-400' }}">New Password</span>
                                </div>
                            </div>
                        </div>

                        <!-- Session Status -->
                        @if (session('status'))
                            <div class="mb-4 p-4 bg-green-100 border border-green-200 text-green-700 rounded-md">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="mb-4 p-4 bg-red-100 border border-red-200 text-red-700 rounded-md">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="mb-4 p-4 bg-green-100 border border-green-200 text-green-700 rounded-md">
                                {{ session('success') }}
                            </div>
                        @endif

                        <!-- Find Account Form -->
                        <div id="find-account-form" class="{{ session('show_security_question') || session('show_reset_form') ? 'hidden' : '' }}">
                            <form method="POST" action="{{ route('password.security.find-user') }}" class="space-y-6">
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
                                <div class="mt-6">
                                    <x-primary-button class="w-full justify-center py-4 bg-blue-600 hover:bg-blue-500 transition-colors duration-200 text-lg font-semibold rounded-lg">
                                        {{ __('Find Account') }}
                                    </x-primary-button>
                                </div>
                            </form>

                            <!-- Alternative Options -->
                            <div class="mt-8 text-center">
                                <p class="text-white/70 mb-4">Other options:</p>
                                <div class="flex justify-center space-x-4">
                                    <a href="{{ route('password.request') }}" class="text-blue-400 hover:text-blue-300 transition-colors">
                                        {{ __('Reset via Email') }}
                                    </a>
                                    <span class="text-white/30">|</span>
                                    <a href="{{ route('login') }}" class="text-blue-400 hover:text-blue-300 transition-colors">
                                        {{ __('Back to Login') }}
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Security Question Form -->
                        <div id="security-question-form" class="{{ session('show_security_question') && !session('show_reset_form') ? '' : 'hidden' }}">
                            <form method="POST" action="{{ route('password.security.validate-answer') }}" class="space-y-6">
                                @csrf

                                <!-- Security Question -->
                                <div>
                                    <x-input-label for="security_answer" :value="session('security_question')" class="text-white text-lg mb-2" />
                                    <x-text-input id="security_answer" 
                                        class="block w-full p-4 bg-white/5 border-0 text-white placeholder-white/30 rounded-lg focus:ring-2 focus:ring-blue-500 transition-all" 
                                        type="text" 
                                        name="security_answer" 
                                        placeholder="Enter your answer"
                                        required 
                                        autofocus />
                                    <p class="mt-2 text-sm text-white/50">{{ __('Note: Your answer is case-sensitive. Enter exactly as you set it up.') }}</p>
                                    <x-input-error :messages="$errors->get('security_answer')" class="mt-2" />
                                </div>

                                <!-- Submit Button -->
                                <div class="mt-6">
                                    <x-primary-button class="w-full justify-center py-4 bg-blue-600 hover:bg-blue-500 transition-colors duration-200 text-lg font-semibold rounded-lg">
                                        {{ __('Verify Answer') }}
                                    </x-primary-button>
                                </div>
                            </form>

                            <!-- Back Button -->
                            <div class="mt-8 text-center">
                                <a href="{{ route('password.security.request') }}" class="text-blue-400 hover:text-blue-300 transition-colors">
                                    {{ __('Start Over') }}
                                </a>
                            </div>
                        </div>

                        <!-- Reset Password Form -->
                        <div id="reset-password-form" class="{{ session('show_reset_form') ? '' : 'hidden' }}">
                            <form method="POST" action="{{ route('password.security.reset') }}" class="space-y-6">
                                @csrf

                                <!-- Password -->
                                <div>
                                    <x-input-label for="password" :value="__('New Password')" class="text-white text-lg mb-2" />
                                    <x-text-input id="password" 
                                        class="block w-full p-4 bg-white/5 border-0 text-white placeholder-white/30 rounded-lg focus:ring-2 focus:ring-blue-500 transition-all" 
                                        type="password" 
                                        name="password" 
                                        placeholder="Enter new password"
                                        required 
                                        autofocus />
                                    <div class="mt-2 text-sm text-white/70">
                                        {{ __('Password must:') }}
                                        <ul class="list-disc list-inside ml-2 space-y-1 text-white/50">
                                            <li>{{ __('Be at least 8 characters long') }}</li>
                                            <li>{{ __('Include at least one uppercase letter') }}</li>
                                            <li>{{ __('Include at least one lowercase letter') }}</li>
                                            <li>{{ __('Include at least one number') }}</li>
                                            <li>{{ __('Include at least one special character (@$!%*?&)') }}</li>
                                        </ul>
                                    </div>
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>

                                <!-- Confirm Password -->
                                <div>
                                    <x-input-label for="password_confirmation" :value="__('Confirm New Password')" class="text-white text-lg mb-2" />
                                    <x-text-input id="password_confirmation" 
                                        class="block w-full p-4 bg-white/5 border-0 text-white placeholder-white/30 rounded-lg focus:ring-2 focus:ring-blue-500 transition-all" 
                                        type="password" 
                                        name="password_confirmation" 
                                        placeholder="Confirm new password"
                                        required />
                                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                </div>

                                <!-- Submit Button -->
                                <div class="mt-6">
                                    <x-primary-button class="w-full justify-center py-4 bg-blue-600 hover:bg-blue-500 transition-colors duration-200 text-lg font-semibold rounded-lg">
                                        {{ __('Reset Password') }}
                                    </x-primary-button>
                                </div>
                            </form>

                            <!-- Back Button -->
                            <div class="mt-8 text-center">
                                <a href="{{ route('password.security.request') }}" class="text-blue-400 hover:text-blue-300 transition-colors">
                                    {{ __('Start Over') }}
                                </a>
                            </div>
                        </div>
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