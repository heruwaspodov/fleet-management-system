<x-layouts.auth title="Register">
    <x-auth-header title="Register a new account" description="Create your account to get started." />

    <form method="POST" action="{{ route('register') }}" class="flex flex-col gap-6">
        @csrf

        <!-- Name -->
        <flux:field>
            <flux:label for="name">{{ __('Name') }}</flux:label>
            <flux:input
                name="name"
                type="text"
                required
                autofocus
                autocomplete="name"
                placeholder="John Doe"
            />
            @error('name')
                <flux:label class="text-red-600 dark:text-red-400 text-sm mt-1">
                    @if(is_array($message))
                        {{ implode(', ', $message) }}
                    @else
                        {{ $message }}
                    @endif
                </flux:label>
            @enderror
        </flux:field>

        <!-- Email Address -->
        <flux:field>
            <flux:label for="email">{{ __('Email') }}</flux:label>
            <flux:input
                name="email"
                type="email"
                required
                autocomplete="username"
                placeholder="email@example.com"
            />
            @error('email')
                <flux:label class="text-red-600 dark:text-red-400 text-sm mt-1">
                    @if(is_array($message))
                        {{ implode(', ', $message) }}
                    @else
                        {{ $message }}
                    @endif
                </flux:label>
            @enderror
        </flux:field>

        <!-- Password -->
        <flux:field>
            <flux:label for="password">{{ __('Password') }}</flux:label>
            <flux:input
                name="password"
                type="password"
                required
                autocomplete="new-password"
                :placeholder="__('Password')"
                viewable
            />
            @error('password')
                <flux:label class="text-red-600 dark:text-red-400 text-sm mt-1">
                    @if(is_array($message))
                        {{ implode(', ', $message) }}
                    @else
                        {{ $message }}
                    @endif
                </flux:label>
            @enderror
        </flux:field>

        <!-- Confirm Password -->
        <flux:field>
            <flux:label for="password_confirmation">{{ __('Confirm Password') }}</flux:label>
            <flux:input
                name="password_confirmation"
                type="password"
                required
                autocomplete="new-password"
                :placeholder="__('Confirm Password')"
                viewable
            />
            @error('password_confirmation')
                <flux:label class="text-red-600 dark:text-red-400 text-sm mt-1">
                    @if(is_array($message))
                        {{ implode(', ', $message) }}
                    @else
                        {{ $message }}
                    @endif
                </flux:label>
            @enderror
        </flux:field>

        <!-- Role (if applicable) -->
        <flux:field>
            <flux:label for="role">{{ __('Role') }}</flux:label>
            <flux:select
                name="role"
                :options="[
                    'employee' => 'Employee',
                    'approver' => 'Approver',
                    'admin' => 'Admin',
                ]"
                :default="'employee'"
            />
            @error('role')
                <flux:label class="text-red-600 dark:text-red-400 text-sm mt-1">
                    @if(is_array($message))
                        {{ implode(', ', $message) }}
                    @else
                        {{ $message }}
                    @endif
                </flux:label>
            @enderror
        </flux:field>

        <!-- Position -->
        <flux:field>
            <flux:label for="position">{{ __('Position') }}</flux:label>
            <flux:input
                name="position"
                type="text"
                autocomplete="organization-title"
                placeholder="Software Engineer"
            />
            @error('position')
                <flux:label class="text-red-600 dark:text-red-400 text-sm mt-1">
                    @if(is_array($message))
                        {{ implode(', ', $message) }}
                    @else
                        {{ $message }}
                    @endif
                </flux:label>
            @enderror
        </flux:field>

        <!-- Department -->
        <flux:field>
            <flux:label for="department">{{ __('Department') }}</flux:label>
            <flux:input
                name="department"
                type="text"
                autocomplete="organization"
                placeholder="Engineering"
            />
            @error('department')
                <flux:label class="text-red-600 dark:text-red-400 text-sm mt-1">
                    @if(is_array($message))
                        {{ implode(', ', $message) }}
                    @else
                        {{ $message }}
                    @endif
                </flux:label>
            @enderror
        </flux:field>

        <!-- Phone -->
        <flux:field>
            <flux:label for="phone">{{ __('Phone') }}</flux:label>
            <flux:input
                name="phone"
                type="tel"
                autocomplete="tel"
                placeholder="+1234567890"
            />
            @error('phone')
                <flux:label class="text-red-600 dark:text-red-400 text-sm mt-1">
                    @if(is_array($message))
                        {{ implode(', ', $message) }}
                    @else
                        {{ $message }}
                    @endif
                </flux:label>
            @enderror
        </flux:field>

        <div class="flex items-center justify-end mt-4">
            <flux:link :href="route('login')" wire:navigate>
                {{ __('Already registered?') }}
            </flux:link>

            <flux:button variant="primary" type="submit" class="ml-4">
                {{ __('Register') }}
            </flux:button>
        </div>
    </form>
</x-layouts.auth>