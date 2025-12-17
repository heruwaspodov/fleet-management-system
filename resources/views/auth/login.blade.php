<x-layouts.auth title="Login">
    <x-auth-header title="Sign in to your account" description="Enter your credentials below." />
    <form action="{{ route('login') }}" method="POST" class="flex flex-col gap-6">
        @csrf
        <flux:field :errors="$errors->get('email')">
            <flux:label for="email">Email</flux:label>
            <flux:input name="email" type="email" value="{{ old('email') }}" required autofocus />
        </flux:field>
        <flux:field :errors="$errors->get('password')">
            <flux:label for="password">Password</flux:label>
            <flux:input name="password" type="password" required />
        </flux:field>
        <div class="flex items-center justify-between">
            <flux:field>
                <flux:checkbox name="remember" label="Remember me" />
            </flux:field>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm">
                    Forgot your password?
                </a>
            @endif
        </div>
        <div class="flex flex-col gap-4">
            <flux:button type="submit" theme="primary" class="w-full">
                Sign in
            </flux:button>
            @if (Route::has('register'))
                <flux:button href="{{ route('register') }}" class="w-full">
                    Create an account
                </flux:button>
            @endif
        </div>
    </form>
</x-layouts.auth>
