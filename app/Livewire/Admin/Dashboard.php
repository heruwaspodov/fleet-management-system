<?php

namespace App\Livewire\Admin;

use App\Models\Booking;
use App\Models\Vehicle;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component
{
    public $totalBookings;
    public $totalVehicles;
    public $totalUsers;
    public $pendingBookings;
    public $approvedBookings;
    public $inProgressBookings;
    public $completedBookings;

    public function mount()
    {
        $this->totalBookings = Booking::count();
        $this->totalVehicles = Vehicle::count();
        $this->totalUsers = User::count();
        $this->pendingBookings = Booking::where('status', 'pending_approval')->count();
        $this->approvedBookings = Booking::where('status', 'approved')->count();
        $this->inProgressBookings = Booking::where('status', 'in_progress')->count();
        $this->completedBookings = Booking::where('status', 'completed')->count();
    }

    public function render()
    {
        // Get booking statistics grouped by month for the last 6 months
        // Use different query for different database systems
        $bookingStats = Booking::selectRaw(
            $this->getDatabaseDateFormat() . ' as month, COUNT(*) as count'
        )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Format data for Chart.js
        $chartLabels = [];
        $chartData = [];

        // Fill in missing months with 0 to ensure the chart shows all 6 months
        $months = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i)->format('Y-m');
            $months[] = $month;
        }

        foreach ($months as $month) {
            $chartLabels[] = date('M Y', strtotime($month . '-01'));
            $stat = $bookingStats->firstWhere('month', $month);
            $chartData[] = $stat ? (int)$stat->count : 0;
        }

        // Get vehicle usage statistics
        $vehicleUsageStats = Vehicle::select('vehicles.id', 'vehicles.plate_number', 'vehicles.brand', 'vehicles.model', DB::raw('COALESCE(booking_counts.count, 0) as count'))
            ->leftJoinSub(
                Booking::select('vehicle_id', DB::raw('COUNT(*) as count'))
                    ->where(function ($query) {
                        $query->where('status', 'completed')
                              ->orWhere('status', 'in_progress');
                    })
                    ->groupBy('vehicle_id'),
                'booking_counts',
                'vehicles.id',
                '=',
                'booking_counts.vehicle_id'
            )
            ->orderByDesc('booking_counts.count')
            ->limit(5)
            ->get();

        return view('livewire.admin.dashboard', [
            'bookingStats' => $bookingStats,
            'vehicleUsageStats' => $vehicleUsageStats,
            'chartLabels' => json_encode($chartLabels),
            'chartData' => json_encode($chartData),
        ]);
    }

    /**
     * Get the appropriate date format string based on the database system
     */
    private function getDatabaseDateFormat()
    {
        $connection = (new Booking())->getConnection();
        $driver = $connection->getDriverName();

        switch ($driver) {
            case 'pgsql':
                return "to_char(created_at, 'YYYY-MM')";
            case 'mysql':
                return "DATE_FORMAT(created_at, '%Y-%m')";
            case 'sqlite':
                return "strftime('%Y-%m', created_at)";
            case 'sqlsrv':
                return "FORMAT(created_at, 'yyyy-MM')";
            default:
                return "DATE_FORMAT(created_at, '%Y-%m')"; // default to MySQL format
        }
    }
}