<x-layouts.auth title="Login">
    <x-auth-header title="Sign in to your account" description="Enter your credentials below." />

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-6">
        @csrf

        <!-- Email Address -->
        <flux:field>
            <flux:label for="email">{{ __('Email') }}</flux:label>
            <flux:input
                name="email"
                type="email"
                required
                autofocus
                autocomplete="username"
                placeholder="email@example.com"
            />
            @error('email')
                <flux:label class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</flux:label>
            @enderror
        </flux:field>

        <!-- Password -->
        <flux:field>
            <flux:label for="password">{{ __('Password') }}</flux:label>
            <flux:input
                name="password"
                type="password"
                required
                autocomplete="current-password"
                :placeholder="__('Password')"
                viewable
            />
            @error('password')
                <flux:label class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</flux:label>
            @enderror
        </flux:field>

        <!-- Remember Me -->
        <div class="flex items-center justify-between mt-4">
            <div class="flex items-center">
                <flux:checkbox id="remember_me" name="remember" label="{{ __('Remember me') }}" />
            </div>

            @if (Route::has('password.request'))
                <flux:link :href="route('password.request')" wire:navigate>
                    {{ __('Forgot your password?') }}
                </flux:link>
            @endif
        </div>

        <div class="mt-4">
            <flux:button variant="primary" type="submit" class="w-full">
                {{ __('Log in') }}
            </flux:button>
        </div>
    </form>

    @if (Route::has('register'))
        <div class="mt-4 text-center text-sm text-zinc-400">
            {{ __("Don't have an account?") }}
            <flux:link :href="route('register')" wire:navigate class="ml-1">
                {{ __('Register') }}
            </flux:link>
        </div>
    @endif
</x-layouts.auth>