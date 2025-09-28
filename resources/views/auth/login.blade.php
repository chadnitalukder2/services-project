<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <h4 style="font-size: 24px; font-weight: 600; text-align: center; padding-bottom: 20px;">Sign In</h4>
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Username or Email -->
        <div>
            <x-input-label for="login" :value="__('Username or Email')" />
            <x-text-input id="login" class="block mt-1 w-full" type="text" name="login" :value="old('login')" required
                autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('login')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <div class="relative">
                <x-text-input id="password" class="block mt-1 w-full pr-10" type="password" name="password" required
                    autocomplete="current-password" />

                <!-- Toggle Button -->
                <button type="button" onclick="togglePassword()"
                    class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500">
                    <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943
                       9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>


        <div class="flex items-center space-x-4 justify-space-between align-center"
            style="justify-content: space-between; margin-bottom: 20px;">
            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox"
                        class="rounded border-gray-300 text-gray-900 shadow-sm focus:outline-none focus:ring-0 focus:ring-offset-0"
                        name="remember">
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-0 focus:ring-offset-0 focus:shadow-none"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <x-primary-button class="ms-3 " style="display: flex;margin: 0 auto; width: 100%; justify-content: center;">
            {{ __('Sign In') }}
        </x-primary-button>


        <div class="flex items-center space-x-4 justify-center "
            style="margin-top: 10px; padding-top:8px; padding-bottom:10px;">
            @if (Route::has('register'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-0 focus:ring-offset-0 focus:shadow-none"
                    href="{{ route('register') }}">
                    {{ __('Don\'t have an account? Register') }}
                </a>
            @endif
        </div>

    </form>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeIcon.setAttribute("d",
                    "M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.971 9.971 0 012.411-3.992m3.03-2.215A9.978 9.978 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.969 9.969 0 01-4.094 5.169M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                    );
            } else {
                passwordInput.type = "password";
                eyeIcon.setAttribute("d", "M15 12a3 3 0 11-6 0 3 3 0 016 0z");
            }
        }
    </script>
</x-guest-layout>
