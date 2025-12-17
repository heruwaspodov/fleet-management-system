<?php

namespace App\Livewire\Booking;

use App\Models\Booking;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    public $search = '';
    public $status = '';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    public function render()
    {
        $query = Booking::query();

        // If user is not admin, only show their bookings
        if (!Auth::user()->isAdmin()) {
            $query->where('user_id', Auth::id());
        }

        // Apply search filter
        if ($this->search) {
            $query->where(function($q) {
                $q->where('booking_code', 'like', '%' . $this->search . '%')
                  ->orWhereHas('user', function($q2) {
                      $q2->where('name', 'like', '%' . $this->search . '%');
                  })
                  ->orWhereHas('vehicle', function($q2) {
                      $q2->where('plate_number', 'like', '%' . $this->search . '%');
                  });
            });
        }

        // Apply status filter
        if ($this->status) {
            $query->where('status', $this->status);
        }

        // Apply sorting
        $query->orderBy($this->sortBy, $this->sortDirection);

        $bookings = $query->with(['user', 'vehicle', 'driver'])->paginate(10);

        return view('livewire.booking.index', [
            'bookings' => $bookings
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
