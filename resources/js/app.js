import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';

// Configure Livewire and Alpine to work together without $persist conflicts
window.Alpine = Alpine;
window.Livewire = Livewire;

// Start Livewire first
Livewire.start();

// Initialize Alpine after Livewire to avoid $persist conflicts
document.addEventListener('DOMContentLoaded', () => {
    // Check if Alpine is already initialized to avoid conflicts
    if (!window.Alpine.booted) {
        Alpine.start();
    }
});