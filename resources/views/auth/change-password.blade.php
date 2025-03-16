<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Change Password') }}
            </h2>
            <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2 text-sm text-gray-600 hover:text-gray-900">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                {{ __('Back to Profile') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="max-w-xl mx-auto">
                        @if(!$hasSecurityQuestion)
                            <!-- Security Question Setup Form -->
                            <div class="mb-8">
                                <div class="mb-6">
                                    <h3 class="text-lg font-medium text-gray-900">{{ __('Setup Security Question') }}</h3>
                                    <p class="mt-1 text-sm text-gray-600">{{ __('Please set up your security question first. This will be used for password recovery and secure password changes.') }}</p>
                                    <p class="mt-2 text-sm text-gray-500">{{ __('Choose a question and answer that:') }}</p>
                                    <ul class="mt-2 text-sm text-gray-500 list-disc list-inside space-y-1">
                                        <li>{{ __('Only you would know the answer to') }}</li>
                                        <li>{{ __('Has an answer that doesn\'t change over time') }}</li>
                                        <li>{{ __('Is not easily guessable or findable online') }}</li>
                                        <li>{{ __('You will remember the exact answer to') }}</li>
                                    </ul>
                                </div>
                                <form method="POST" action="{{ route('password.setup-security-question') }}" class="space-y-4">
                                    @csrf
                                    <div>
                                        <x-input-label for="security_question" :value="__('Choose Your Security Question')" />
                                        <select id="security_question" name="security_question" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                            <option value="">{{ __('Select a question') }}</option>
                                            <option value="What was the name of your first pet?">{{ __('What was the name of your first pet?') }}</option>
                                            <option value="In what city did your parents meet?">{{ __('In what city did your parents meet?') }}</option>
                                            <option value="What was the name of your first teacher?">{{ __('What was the name of your first teacher?') }}</option>
                                            <option value="What was the model of your first car?">{{ __('What was the model of your first car?') }}</option>
                                            <option value="What is your maternal grandmother's first name?">{{ __('What is your maternal grandmother\'s first name?') }}</option>
                                        </select>
                                        <x-input-error :messages="$errors->get('security_question')" class="mt-2" />
                                    </div>
                                    <div>
                                        <x-input-label for="security_answer" :value="__('Your Answer')" />
                                        <x-text-input 
                                            id="security_answer" 
                                            name="security_answer" 
                                            type="text" 
                                            class="mt-1 block w-full" 
                                            required 
                                            autocomplete="off"
                                            placeholder="{{ __('Enter your answer') }}"
                                        />
                                        <p class="mt-2 text-sm text-gray-500">{{ __('Note: Your answer is case-sensitive. Remember exactly how you write it.') }}</p>
                                        <x-input-error :messages="$errors->get('security_answer')" class="mt-2" />
                                    </div>
                                    <div class="flex items-center justify-end mt-4">
                                        <x-primary-button>
                                            {{ __('Save Security Question') }}
                                        </x-primary-button>
                                    </div>
                                </form>
                            </div>
                        @else
                            <!-- Progress Steps -->
                            <div class="mb-8">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <span class="w-8 h-8 rounded-full {{ !session('show_password_form') && !session('show_otp_form') ? 'bg-indigo-600 text-white' : 'bg-gray-200' }} flex items-center justify-center text-sm font-semibold">1</span>
                                        <span class="ml-2 text-sm font-medium {{ !session('show_password_form') && !session('show_otp_form') ? 'text-gray-900' : 'text-gray-500' }}">Security Question</span>
                                    </div>
                                    <div class="flex-1 mx-4 h-0.5 {{ session('show_password_form') || session('show_otp_form') ? 'bg-indigo-600' : 'bg-gray-200' }}"></div>
                                    <div class="flex items-center">
                                        <span class="w-8 h-8 rounded-full {{ session('show_password_form') && !session('show_otp_form') ? 'bg-indigo-600 text-white' : 'bg-gray-200' }} flex items-center justify-center text-sm font-semibold">2</span>
                                        <span class="ml-2 text-sm font-medium {{ session('show_password_form') && !session('show_otp_form') ? 'text-gray-900' : 'text-gray-500' }}">New Password</span>
                                    </div>
                                    <div class="flex-1 mx-4 h-0.5 {{ session('show_otp_form') ? 'bg-indigo-600' : 'bg-gray-200' }}"></div>
                                    <div class="flex items-center">
                                        <span class="w-8 h-8 rounded-full {{ session('show_otp_form') ? 'bg-indigo-600 text-white' : 'bg-gray-200' }} flex items-center justify-center text-sm font-semibold">3</span>
                                        <span class="ml-2 text-sm font-medium {{ session('show_otp_form') ? 'text-gray-900' : 'text-gray-500' }}">OTP Verification</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Security Question Form -->
                            <div id="security-question-form" class="{{ session('show_password_form') ? 'hidden' : '' }}">
                                <div class="mb-6">
                                    <h3 class="text-lg font-medium text-gray-900">{{ __('Security Verification') }}</h3>
                                    <p class="mt-1 text-sm text-gray-600">{{ __('Please answer your security question to proceed with password change.') }}</p>
                                </div>
                                <form method="POST" action="{{ route('password.validate-security-question') }}" class="space-y-4">
                                    @csrf
                                    <div>
                                        <x-input-label for="security_answer" :value="auth()->user()->security_question" />
                                        <x-text-input id="security_answer" name="security_answer" type="text" class="mt-1 block w-full" required autofocus />
                                        <x-input-error :messages="$errors->get('security_answer')" class="mt-2" />
                                    </div>
                                    <div class="flex items-center justify-end mt-4">
                                        <x-primary-button>
                                            {{ __('Submit Answer') }}
                                        </x-primary-button>
                                    </div>
                                </form>
                            </div>

                            <!-- Password Change Form -->
                            <div id="password-form" class="{{ session('show_password_form') ? '' : 'hidden' }}">
                                <div class="mb-6">
                                    <h3 class="text-lg font-medium text-gray-900">{{ __('New Password') }}</h3>
                                    <p class="mt-1 text-sm text-gray-600">{{ __('Choose a strong password that you haven\'t used before.') }}</p>
                                </div>
                                <form method="POST" action="{{ route('password.generate-otp') }}" class="space-y-4">
                                    @csrf
                                    <div>
                                        <x-input-label for="new_password" :value="__('New Password')" />
                                        <x-text-input id="new_password" name="new_password" type="password" class="mt-1 block w-full" required />
                                        <div class="mt-2 text-sm text-gray-600">
                                            {{ __('Password must:') }}
                                            <ul class="list-disc list-inside ml-2 space-y-1">
                                                <li>{{ __('Be at least 8 characters long') }}</li>
                                                <li>{{ __('Include at least one uppercase letter') }}</li>
                                                <li>{{ __('Include at least one lowercase letter') }}</li>
                                                <li>{{ __('Include at least one number') }}</li>
                                                <li>{{ __('Include at least one special character (@$!%*?&)') }}</li>
                                            </ul>
                                        </div>
                                        <x-input-error :messages="$errors->get('new_password')" class="mt-2" />
                                    </div>
                                    <div>
                                        <x-input-label for="new_password_confirmation" :value="__('Confirm New Password')" />
                                        <x-text-input id="new_password_confirmation" name="new_password_confirmation" type="password" class="mt-1 block w-full" required />
                                        <x-input-error :messages="$errors->get('new_password_confirmation')" class="mt-2" />
                                    </div>
                                    <div class="flex items-center justify-end mt-4">
                                        <x-primary-button>
                                            {{ __('Generate OTP') }}
                                        </x-primary-button>
                                    </div>
                                </form>
                            </div>

                            <!-- OTP Verification Form -->
                            <div id="otp-form" class="{{ session('show_otp_form') ? '' : 'hidden' }}">
                                <div class="mb-6">
                                    <h3 class="text-lg font-medium text-gray-900">{{ __('OTP Verification') }}</h3>
                                    <p class="mt-1 text-sm text-gray-600">{{ __('Enter the 6-digit OTP code shown in the message box.') }}</p>
                                </div>
                                <form method="POST" action="{{ route('password.verify-otp') }}" class="space-y-4">
                                    @csrf
                                    <div>
                                        <x-input-label for="otp" :value="__('Enter OTP')" />
                                        <x-text-input 
                                            id="otp" 
                                            name="otp" 
                                            type="text" 
                                            class="mt-1 block w-full tracking-widest text-center text-xl" 
                                            required 
                                            maxlength="6" 
                                            pattern="[0-9]*" 
                                            inputmode="numeric"
                                            autocomplete="off"
                                            placeholder="000000"
                                        />
                                        <p class="mt-2 text-sm text-gray-500">{{ __('OTP will expire in 2 minutes') }}</p>
                                        <x-input-error :messages="$errors->get('otp')" class="mt-2" />
                                    </div>
                                    <div class="flex items-center justify-end mt-4">
                                        <x-primary-button>
                                            {{ __('Verify OTP') }}
                                        </x-primary-button>
                                    </div>
                                </form>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="mt-6 p-4 bg-red-100 border border-red-200 text-red-700 rounded-md">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if(session('success'))
                            <div class="mt-6 p-4 bg-green-100 border border-green-200 text-green-700 rounded-md">
                                {{ session('success') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 