<?php

namespace App\Livewire\Admin\Reports;

use App\Models\Booking;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class BookingReport extends Component
{
    use WithPagination;

    public $startDate;
    public $endDate;
    public $totalBookings;
    public $totalApproved;
    public $totalRejected;
    public $totalCompleted;

    // Pagination
    protected $paginationTheme = 'tailwind';
    public $perPage = 10;

    public function mount()
    {
        $this->startDate = now()->subDays(30)->format('Y-m-d');
        $this->endDate = now()->format('Y-m-d');
        $this->loadReport();
    }

    public function updated($field)
    {
        if ($field === 'startDate' || $field === 'endDate' || $field === 'perPage') {
            $this->loadReport();
        }
    }

    public function loadReport()
    {
        $query = Booking::with(['user', 'vehicle', 'driver', 'approvals']);

        if ($this->startDate) {
            $query->whereDate('created_at', '>=', $this->startDate);
        }

        if ($this->endDate) {
            $query->whereDate('created_at', '<=', $this->endDate);
        }

        // Calculate totals for the filtered results (all records, not just the paginated ones)
        $allFilteredBookings = $query->get();
        $this->totalBookings = $allFilteredBookings->count();
        $this->totalApproved = $allFilteredBookings->where('status', 'approved')->count();
        $this->totalRejected = $allFilteredBookings->where('status', 'rejected')->count();
        $this->totalCompleted = $allFilteredBookings->where('status', 'completed')->count();
    }

    public function exportToExcel()
    {
        // Redirect to the export controller - this uses the full query without pagination
        return redirect()->route('export.booking-report', [
            'start_date' => $this->startDate,
            'end_date' => $this->endDate
        ]);
    }

    public function render()
    {
        $query = Booking::with(['user', 'vehicle', 'driver', 'approvals']);

        if ($this->startDate) {
            $query->whereDate('created_at', '>=', $this->startDate);
        }

        if ($this->endDate) {
            $query->whereDate('created_at', '<=', $this->endDate);
        }

        $bookings = $query->orderBy('created_at', 'desc')->paginate($this->perPage);

        return view('livewire.admin.reports.booking-report', [
            'bookings' => $bookings,
        ]);
    }
}