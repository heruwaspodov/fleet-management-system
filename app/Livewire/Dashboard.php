<?php

namespace App\Livewire;

use App\Models\Booking;
use App\Models\Vehicle;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component
{
    public $totalVehicles;
    public $availableVehicles;
    public $bookedVehicles;
    public $totalBookings;
    public $pendingBookings;
    public $approvedBookings;
    public $completedBookings;
    public $inProgressBookings;
    public $rejectedBookings;
    public $totalUsers;
    public $totalDrivers;
    public $bookingChart;
    public $vehicleUsageChart;
    public $monthlyBookings;

    public function mount()
    {
        $this->loadDashboardData();
    }

    public function render()
    {
        return view('livewire.dashboard');
    }

    private function loadDashboardData()
    {
        // Vehicle data
        $this->totalVehicles = Vehicle::count();
        $this->availableVehicles = Vehicle::where('status', 'available')->count();
        $this->bookedVehicles = Vehicle::where('status', 'booked')->count();

        // Booking data
        $this->totalBookings = Booking::count();
        $this->pendingBookings = Booking::where('status', 'pending_approval')->count();
        $this->approvedBookings = Booking::where('status', 'approved')->count();
        $this->completedBookings = Booking::where('status', 'completed')->count();
        $this->inProgressBookings = Booking::where('status', 'in_progress')->count();
        $this->rejectedBookings = Booking::where('status', 'rejected')->count();

        // User data
        $this->totalUsers = User::count();
        $this->totalDrivers = User::where('role', 'employee')->count();

        // Prepare booking chart data (last 7 days)
        $bookingChart = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $count = Booking::whereDate('created_at', $date)->count();

            $bookingChart[] = [
                'date' => $date->format('Y-m-d'),
                'count' => $count,
                'day' => $date->format('D')
            ];
        }

        $this->bookingChart = $bookingChart;

        // Prepare vehicle usage chart data (top 5 vehicles by bookings)
        $vehicleUsage = [];
        $vehicles = Vehicle::withCount('bookings')->orderBy('bookings_count', 'desc')->limit(5)->get();

        foreach ($vehicles as $vehicle) {
            $vehicleUsage[] = [
                'vehicle' => $vehicle->plate_number,
                'bookings' => $vehicle->bookings_count
            ];
        }

        $this->vehicleUsageChart = $vehicleUsage;

        // Prepare monthly booking data for current year
        $connection = (new Booking())->getConnection();
        $driverName = $connection->getDriverName();

        if ($driverName === 'pgsql') {
            // For PostgreSQL, use EXTRACT function
            $this->monthlyBookings = Booking::select(
                DB::raw('EXTRACT(MONTH FROM created_at) as month'),
                DB::raw('COUNT(*) as count')
            )
            ->whereYear('created_at', now()->year)
            ->groupBy(DB::raw('EXTRACT(MONTH FROM created_at)'))
            ->orderBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();
        } elseif ($driverName === 'sqlite') {
            // For SQLite, use strftime function
            $this->monthlyBookings = Booking::select(
                DB::raw("strftime('%m', created_at) as month"),
                DB::raw('COUNT(*) as count')
            )
            ->whereYear('created_at', now()->year)
            ->groupBy(DB::raw("strftime('%m', created_at)"))
            ->orderBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();
        } else {
            // For MySQL and other databases, use MONTH function
            $this->monthlyBookings = Booking::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as count')
            )
            ->whereYear('created_at', now()->year)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();
        }
    }
}
