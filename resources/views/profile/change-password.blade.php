<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Change Password') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    @if (session('success'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-4 font-medium text-sm text-red-600">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Security Question Form -->
                    @if(session('show_security_form', true))
                        <form method="POST" action="{{ route('profile.validate-security') }}">
                            @csrf
                            <div class="mt-4">
                                <x-input-label for="security_answer" :value="__('Security Question: What is your favorite color?')" />
                                <x-text-input id="security_answer" class="block mt-1 w-full" type="text" name="security_answer" required />
                                <x-input-error :messages="$errors->get('security_answer')" class="mt-2" />
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <x-primary-button class="ml-4">
                                    {{ __('Validate Security Question') }}
                                </x-primary-button>
                            </div>
                        </form>
                    @endif

                    <!-- Password Change Form -->
                    @if(session('show_password_form'))
                        <form method="POST" action="{{ route('profile.validate-password') }}">
                            @csrf
                            <div class="mt-4">
                                <x-input-label for="new_password" :value="__('New Password')" />
                                <x-text-input id="new_password" class="block mt-1 w-full" type="password" name="new_password" required />
                                <x-input-error :messages="$errors->get('new_password')" class="mt-2" />
                            </div>

                            <div class="mt-4">
                                <x-input-label for="new_password_confirmation" :value="__('Confirm New Password')" />
                                <x-text-input id="new_password_confirmation" class="block mt-1 w-full" type="password" name="new_password_confirmation" required />
                            </div>

                            <!-- Password Requirements -->
                            <div class="bg-gray-100 rounded-lg p-4 mt-4">
                                <p class="text-gray-700 font-medium mb-2">Password Requirements:</p>
                                <ul class="text-sm text-gray-600 space-y-1 list-disc list-inside">
                                    <li>Minimum 12 characters long</li>
                                    <li>Must include uppercase and lowercase letters</li>
                                    <li>Must include at least one number</li>
                                    <li>Must include at least one special character</li>
                                </ul>
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <x-primary-button class="ml-4">
                                    {{ __('Generate OTP') }}
                                </x-primary-button>
                            </div>
                        </form>
                    @endif

                    <!-- OTP Validation Form -->
                    @if(session('show_otp_form'))
                        <form method="POST" action="{{ route('profile.validate-otp') }}">
                            @csrf
                            <div class="mt-4">
                                <x-input-label for="otp" :value="__('Enter OTP')" />
                                <x-text-input id="otp" class="block mt-1 w-full" type="text" name="otp" required />
                                <x-input-error :messages="$errors->get('otp')" class="mt-2" />
                                <p class="text-sm text-gray-600 mt-2">OTP will expire in 2 minutes.</p>
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <x-primary-button class="ml-4">
                                    {{ __('Validate OTP') }}
                                </x-primary-button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
