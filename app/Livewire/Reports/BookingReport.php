<?php

namespace App\Livewire\Reports;

use App\Models\Booking as BookingModel;
use Livewire\Component;

class BookingReport extends Component
{
    public $startDate;
    public $endDate;
    public $status = '';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    protected $queryString = ['startDate', 'endDate', 'status'];

    public function mount()
    {
        // Set default date range to last 30 days
        $this->startDate = now()->subDays(30)->format('Y-m-d');
        $this->endDate = now()->format('Y-m-d');
    }

    public function render()
    {
        $query = BookingModel::query();

        // Apply date range filter
        if ($this->startDate && $this->endDate) {
            $query->whereBetween('created_at', [$this->startDate . ' 00:00:00', $this->endDate . ' 23:59:59']);
        }

        // Apply status filter
        if ($this->status) {
            $query->where('status', $this->status);
        }

        // Apply sorting
        $query->orderBy($this->sortBy, $this->sortDirection);

        $bookings = $query->with(['user', 'vehicle', 'driver'])->paginate(20);

        // Get summary statistics
        $totalBookings = $query->count();
        $totalApproved = $query->where('status', 'approved')->count();
        $totalRejected = $query->where('status', 'rejected')->count();
        $totalPending = $query->where('status', 'pending_approval')->count();

        return view('livewire.reports.booking', [
            'bookings' => $bookings,
            'totalBookings' => $totalBookings,
            'totalApproved' => $totalApproved,
            'totalRejected' => $totalRejected,
            'totalPending' => $totalPending,
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

    public function export()
    {
        // Redirect to export endpoint with parameters
        return redirect()->route('export.booking-report', [
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
            'status' => $this->status,
        ]);
    }
}
