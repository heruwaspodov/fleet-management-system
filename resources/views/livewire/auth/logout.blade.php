<?php

use Livewire\Volt\Component;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    /**
     * Log the current user out of the application.
     */
    public function logout(): void
    {
        Auth::guard('web')->logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        $this->redirect('/', navigate: true);
    }
}; ?>

<div class="relative">
    <!-- User dropdown menu -->
    <button
        type="button"
        x-data="{ open: false }"
        @click="open = !open"
        @keydown.escape="open = false"
        @click.away="open = false"
        class="flex text-sm rounded-full focus:outline-none focus:ring-1 focus:ring-offset-1 focus:ring-indigo-500"
        id="user-menu-button"
        aria-expanded="false"
        aria-haspopup="true">
        <span class="sr-only">Open user menu</span>
        <div class="h-8 w-8 rounded-full bg-indigo-500 flex items-center justify-center text-white">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>
    </button>

    <!-- Dropdown menu -->
    <div x-data="{ open: false }" 
         @click.away="open = false"
         @keydown.escape="open = false"
         x-show="open"
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
         role="menu"
         aria-orientation="vertical"
         aria-labelledby="user-menu-button"
         tabindex="-1">
        
        <div class="px-4 py-2 border-b">
            <p class="text-sm font-medium text-gray-900 truncate" title="{{ auth()->user()->email }}">
                {{ auth()->user()->name }}
            </p>
            <p class="text-xs text-gray-500 truncate" title="{{ auth()->user()->email }}">
                {{ auth()->user()->email }}
            </p>
        </div>
        
        <div class="px-4 py-2">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Role</p>
            <p class="text-sm text-gray-900 capitalize">{{ auth()->user()->role }}</p>
        </div>
        
        <a href="{{ route('dashboard') }}" 
           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
           role="menuitem"
           tabindex="-1"
           @click="open = false">
            Dashboard
        </a>
        
        <button 
            wire:click="logout"
            class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
            role="menuitem"
            tabindex="-1">
            Sign out
        </button>
    </div>
</div>