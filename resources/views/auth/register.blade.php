<x-layouts.auth title="Create an account">
    <x-auth-header title="Create an account" description="Enter your details below." />
    <form action="{{ route('register') }}" method="POST" class="flex flex-col gap-6">
        @csrf
        <flux:field :errors="$errors->get('name')">
            <flux:label for="name">Name</flux:label>
            <flux:input name="name" value="{{ old('name') }}" required autofocus />
        </flux:field>
        <flux:field :errors="$errors->get('email')">
            <flux:label for="email">Email</flux:label>
            <flux:input name="email" type="email" value="{{ old('email') }}" required />
        </flux:field>
        <flux:field :errors="$errors->get('password')">
            <flux:label for="password">Password</flux:label>
            <flux:input name="password" type="password" required />
        </flux:field>
        <flux:field :errors="$errors->get('password_confirmation')">
            <flux:label for="password_confirmation">Confirm Password</flux:label>
            <flux:input name="password_confirmation" type="password" required />
        </flux:field>
        <div class="flex flex-col gap-4">
            <flux:button type="submit" theme="primary" class="w-full">
                Register
            </flux:button>
            <flux:button href="{{ route('login') }}" class="w-full">
                Already have an account?
            </flux:button>
        </div>
    </form>
</x-layouts.auth>
