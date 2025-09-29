<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <!-- Current Password -->
        <div class="relative">
            <x-input-label for="current_password" :value="__('Current Password')" />

            <x-text-input 
                id="current_password" 
                name="current_password" 
                type="password" 
                class="mt-1 block w-full pr-10" 
                autocomplete="current-password" 
            />

            <button type="button" style="margin-top: 22px;" onclick="togglePassword('current_password', 'current_eye')" 
                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500">
                <svg id="current_eye" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
            </button>

            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <!-- New Password -->
        <div class="relative">
            <x-input-label for="password" :value="__('New Password')" />

            <x-text-input 
                id="password" 
                name="password" 
                type="password" 
                class="mt-1 block w-full pr-10" 
                autocomplete="new-password" 
            />

            <button type="button" style="margin-top: 22px;" onclick="togglePassword('password', 'password_eye')" 
                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500">
                <svg id="password_eye" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
            </button>

            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="relative">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input 
                id="password_confirmation" 
                name="password_confirmation" 
                type="password" 
                class="mt-1 block w-full pr-10" 
                autocomplete="new-password" 
            />

            <button type="button" style="margin-top: 22px;" onclick="togglePassword('password_confirmation', 'confirm_eye')" 
                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500">
                <svg id="confirm_eye" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
            </button>

            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p class="text-sm text-gray-600" id="saved-msg">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>

    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (input.type === "password") {
                input.type = "text";
            } else {
                input.type = "password";
            }
        }

        // Optional: hide saved message after 2 seconds
        const savedMsg = document.getElementById('saved-msg');
        if(savedMsg) {
            setTimeout(() => { savedMsg.style.display = 'none'; }, 2000);
        }
    </script>
</section>
