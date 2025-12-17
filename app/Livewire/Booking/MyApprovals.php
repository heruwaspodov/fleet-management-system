<?php

namespace App\Livewire\Booking;

use App\Models\Approval as ApprovalModel;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class MyApprovals extends Component
{
    public $search = '';
    public $status = 'pending';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    public function render()
    {
        $query = ApprovalModel::query();

        // Only show approvals assigned to the current user
        $query->where('approver_id', Auth::id());

        // Apply status filter (default to pending)
        if ($this->status) {
            $query->where('status', $this->status);
        }

        // Apply search filter
        if ($this->search) {
            $query->whereHas('booking', function($q) {
                $q->where('booking_code', 'like', '%' . $this->search . '%')
                  ->orWhereHas('user', function($q2) {
                      $q2->where('name', 'like', '%' . $this->search . '%');
                  })
                  ->orWhereHas('vehicle', function($q2) {
                      $q2->where('plate_number', 'like', '%' . $this->search . '%');
                  });
            });
        }

        // Apply sorting
        $query->orderBy($this->sortBy, $this->sortDirection);

        $approvals = $query->with(['booking.user', 'booking.vehicle', 'booking.driver'])->paginate(10);

        return view('livewire.booking.my-approvals', [
            'approvals' => $approvals
        ]);
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }
}
