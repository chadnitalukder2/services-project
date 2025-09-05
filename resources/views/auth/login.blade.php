<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <h4 style="font-size: 24px; font-weight: 600; text-align: center; padding-bottom: 20px;">Sign In</h4>
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>


        <div class="flex items-center space-x-4 justify-space-between align-center" style="justify-content: space-between; margin-bottom: 20px;">
            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox"
                        class="rounded border-gray-300 text-gray-900 shadow-sm focus:outline-none focus:ring-0 focus:ring-offset-0" name="remember">
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
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-0 focus:ring-offset-0 focus:shadow-none" href="{{ route('register') }}">
                        {{ __('Don\'t have an account? Register') }}
                    </a>
                @endif
        </div>

    </form>
</x-guest-layout>
