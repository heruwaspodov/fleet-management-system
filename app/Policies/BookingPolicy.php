<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BookingPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isApprover();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Booking $booking): bool
    {
        return $user->isAdmin() ||
               $user->isApprover() ||
               $user->id === $booking->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isEmployee();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Booking $booking): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        // User can update their own booking if it's still in draft
        if ($user->id === $booking->user_id && $booking->isDraft()) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Booking $booking): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        // User can delete their own booking if it's still in draft
        if ($user->id === $booking->user_id && $booking->isDraft()) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Booking $booking): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Booking $booking): bool
    {
        return false;
    }

    /**
     * Determine whether the user can approve the booking.
     */
    public function approve(User $user, Booking $booking): bool
    {
        if (!$user->isApprover()) {
            return false;
        }

        // Check if the user is assigned to approve this booking at their level
        $pendingApproval = $booking->approvals()
            ->where('status', 'pending')
            ->orderBy('level')
            ->first();

        if (!$pendingApproval) {
            return false;
        }

        return $user->id === $pendingApproval->approver_id;
    }

    /**
     * Determine whether the user can assign driver.
     */
    public function assignDriver(User $user, Booking $booking): bool
    {
        return $user->isAdmin();
    }
}
