<?php

namespace App\Livewire\Booking;

use App\Models\Booking;
use App\Models\Approval as ApprovalModel;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Approval extends Component
{
    public $booking;
    public $approval;
    public $comment = '';
    public $status; // 'approved' or 'rejected'

    public function mount($id)
    {
        $this->booking = Booking::with(['user', 'vehicle', 'approvals', 'approvals.approver'])->findOrFail($id);

        // Find the pending approval for the current user
        $this->approval = $this->booking->approvals()
            ->where('approver_id', Auth::id())
            ->where('status', 'pending')
            ->orderBy('level')
            ->first();

        if (!$this->approval) {
            abort(403, 'You are not authorized to approve this booking.');
        }
    }

    public function render()
    {
        return view('livewire.booking.approval');
    }

    public function submitApproval()
    {
        $this->validate([
            'status' => 'required|in:approved,rejected',
            'comment' => 'nullable|string',
        ]);

        // Update the approval status
        $this->approval->update([
            'status' => $this->status,
            'comments' => $this->comment,
            'approved_at' => now(),
        ]);

        // Update the booking status if all approvals are completed
        $this->updateBookingStatus();

        // Redirect with message
        session()->flash('message',
            $this->status === 'approved'
                ? 'Booking approved successfully.'
                : 'Booking rejected.'
        );

        return $this->redirect('/my-approvals', navigate: true);
    }

    private function updateBookingStatus()
    {
        $booking = $this->booking;

        // Check if there are any pending approvals
        $pendingApproval = $booking->approvals()->where('status', 'pending')->first();

        if ($pendingApproval) {
            // If there are still pending approvals, keep status as pending_approval
            $booking->update(['status' => 'pending_approval']);
        } else {
            // Check if any approval was rejected
            $rejectedApproval = $booking->approvals()->where('status', 'rejected')->first();

            if ($rejectedApproval) {
                // If any approval was rejected, the whole booking is rejected
                $booking->update(['status' => 'rejected']);
            } else {
                // All approvals are approved, set booking to approved
                $booking->update(['status' => 'approved']);
            }
        }
    }
}
