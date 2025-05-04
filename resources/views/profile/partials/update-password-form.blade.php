<section>
    <header>
        <h2 class="text-lg font-medium text-primary-900 border-b border-primary-100 pb-2">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-2 text-sm text-primary-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>

        <div class="mt-3">
            <a href="{{ route('password.change-form') }}" class="text-sm text-primary-700 hover:text-primary-900 flex items-center transition-colors duration-150">
                {{ __('Want to change password with additional security? Click here for OTP verification') }}
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </a>
        </div>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6" id="passwordForm">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Current Password')" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('New Password')" />
            <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
            <div class="mt-2 text-sm text-primary-700 bg-primary-50 p-3 rounded-md">
                <div class="font-medium mb-1">{{ __('Password must:') }}</div>
                <ul class="list-disc list-inside ml-2 space-y-1 text-primary-600">
                    <li>{{ __('Be at least 8 characters long') }}</li>
                    <li>{{ __('Include at least one uppercase letter') }}</li>
                    <li>{{ __('Include at least one lowercase letter') }}</li>
                    <li>{{ __('Include at least one number') }}</li>
                    <li>{{ __('Include at least one special character (@$!%*?&)') }}</li>
                </ul>
            </div>
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button type="button" onclick="generateOTP()">{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-primary-700 bg-primary-50 px-3 py-1 rounded-md"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>

    <!-- OTP Modal -->
    <div id="otpModal" class="fixed inset-0 bg-primary-900 bg-opacity-50 hidden overflow-y-auto h-full w-full" x-data="{ show: false }">
        <div class="relative top-20 mx-auto p-5 border border-primary-100 w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-primary-900 border-b border-primary-100 pb-2 mb-3">{{ __('OTP Verification') }}</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-primary-700 mb-4">{{ __('Your OTP code is:') }}</p>
                    <div id="otpDisplay" class="text-2xl font-bold text-primary-800 mb-4 bg-primary-50 py-2 rounded-md"></div>
                    <p class="text-sm text-primary-600 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ __('This OTP will expire in 2 minutes.') }}
                    </p>
                    <div class="mt-4">
                        <x-input-label for="otp" :value="__('Enter OTP')" />
                        <x-text-input
                            id="otp"
                            type="text"
                            class="mt-1 block w-full tracking-widest text-center text-xl"
                            required
                            maxlength="6"
                            pattern="[0-9]*"
                            inputmode="numeric"
                            autocomplete="off"
                            placeholder="000000"
                        />
                    </div>
                </div>
                <div class="items-center px-4 py-3">
                    <x-primary-button onclick="verifyOTP()" class="w-full justify-center">
                        {{ __('Verify OTP') }}
                    </x-primary-button>
                    <button onclick="closeOTPModal()" class="mt-3 w-full inline-flex justify-center px-4 py-2 text-sm font-medium text-primary-700 border border-primary-200 rounded-md hover:bg-primary-50 focus:outline-none transition-colors duration-150">
                        {{ __('Cancel') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let generatedOTP = '';
        let otpExpiry = null;

        function generateOTP() {
            // Basic form validation
            const password = document.getElementById('update_password_password').value;
            const confirmPassword = document.getElementById('update_password_password_confirmation').value;
            const currentPassword = document.getElementById('update_password_current_password').value;

            if (!currentPassword || !password || !confirmPassword) {
                alert('Please fill in all password fields.');
                return;
            }

            if (password !== confirmPassword) {
                alert('Passwords do not match.');
                return;
            }

            // Generate 6-digit OTP
            generatedOTP = Math.floor(100000 + Math.random() * 900000).toString();
            otpExpiry = new Date(new Date().getTime() + 2 * 60000); // 2 minutes from now

            // Display OTP
            document.getElementById('otpDisplay').textContent = generatedOTP;
            document.getElementById('otpModal').classList.remove('hidden');
            document.getElementById('otp').value = '';
        }

        function verifyOTP() {
            const enteredOTP = document.getElementById('otp').value;
            const now = new Date();

            if (now > otpExpiry) {
                alert('OTP has expired. Please generate a new one.');
                closeOTPModal();
                return;
            }

            if (enteredOTP === generatedOTP) {
                document.getElementById('passwordForm').submit();
            } else {
                alert('Invalid OTP. Please try again.');
            }
        }

        function closeOTPModal() {
            document.getElementById('otpModal').classList.add('hidden');
            generatedOTP = '';
            otpExpiry = null;
        }
    </script>
</section>