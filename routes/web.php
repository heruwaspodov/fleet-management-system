<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;
use App\Http\Controllers\ExportController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('dashboard', App\Livewire\Dashboard::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Admin routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', App\Livewire\Admin\Dashboard::class)->name('dashboard');
        Route::get('/bookings', App\Livewire\Booking\Index::class)->name('bookings.index');
        Route::get('/bookings/create', App\Livewire\Admin\Bookings\Create::class)->name('bookings.create');
        Route::get('/reports/booking', App\Livewire\Admin\Reports\BookingReport::class)->name('reports.booking');
        Route::get('/approvals', App\Livewire\Admin\Approval\Index::class)->name('approvals.index');
    });
});

// Booking routes
Route::middleware(['auth'])->group(function () {
    Route::get('/bookings', App\Livewire\Booking\Index::class)->name('bookings.index');
    Route::get('/bookings/create', App\Livewire\Booking\Create::class)->name('booking.create');
    Route::get('/bookings/{id}', function ($id) {
        return view('livewire.booking.show', ['bookingId' => $id]);
    })->name('booking.show');
    Route::get('/bookings/{id}/edit', function ($id) {
        return view('livewire.booking.edit', ['bookingId' => $id]);
    })->name('booking.edit');

    // Approval routes
    Route::get('/my-approvals', App\Livewire\Booking\MyApprovals::class)->name('my-approvals');
    Route::get('/bookings/{id}/approve', App\Livewire\Booking\Approval::class)->name('booking.approval');

    // Report routes
    Route::get('/reports/bookings', App\Livewire\Reports\BookingReport::class)->name('reports.booking');

    // Export routes
    Route::get('/export/booking-report', [ExportController::class, 'exportBookingReport'])
        ->name('export.booking-report');

    // Settings routes
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('user-password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});
