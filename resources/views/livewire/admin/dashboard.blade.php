<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Admin Dashboard</h1>
        <p class="mt-2 text-gray-600">Manage and monitor all vehicle bookings</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow border">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-bold text-gray-900">{{ $totalBookings }}</h3>
                    <p class="text-gray-500">Total Bookings</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow border">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-bold text-gray-900">{{ $approvedBookings }}</h3>
                    <p class="text-gray-500">Approved</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow border">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-bold text-gray-900">{{ $pendingBookings }}</h3>
                    <p class="text-gray-500">Pending Approval</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow border">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 14l9-5-9-5-9 5 9 5z"></path>
                        <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-bold text-gray-900">{{ $totalVehicles }}</h3>
                    <p class="text-gray-500">Total Vehicles</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Booking and Vehicle Stats -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Booking Statistics Chart -->
        <div class="bg-white p-6 rounded-lg shadow border">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Booking Trend (Last 6 Months)</h2>
            <div>
                <canvas id="bookingChart" width="400" height="200"></canvas>
            </div>
        </div>

        <!-- Top Used Vehicles -->
        <div class="bg-white p-6 rounded-lg shadow border">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Top Used Vehicles</h2>
            <div class="space-y-4">
                @forelse($vehicleUsageStats as $vehicle)
                <div class="flex items-center justify-between p-3 border-b border-gray-100">
                    <div>
                        <h3 class="font-medium">{{ $vehicle->brand }} {{ $vehicle->model }}</h3>
                        <p class="text-sm text-gray-500">{{ $vehicle->plate_number }}</p>
                    </div>
                    <div class="text-right">
                        <span class="font-bold text-indigo-600">{{ $vehicle->count }}</span>
                        <span class="text-sm text-gray-500">bookings</span>
                    </div>
                </div>
                @empty
                <p class="text-gray-500 text-center py-4">No vehicle usage data available</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Additional Stats -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-lg shadow border">
            <h3 class="text-lg font-medium text-gray-900 mb-2">In Progress</h3>
            <p class="text-3xl font-bold text-indigo-600">{{ $inProgressBookings }}</p>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow border">
            <h3 class="text-lg font-medium text-gray-900 mb-2">Completed</h3>
            <p class="text-3xl font-bold text-green-600">{{ $completedBookings }}</p>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow border">
            <h3 class="text-lg font-medium text-gray-900 mb-2">Total Users</h3>
            <p class="text-3xl font-bold text-purple-600">{{ $totalUsers }}</p>
        </div>
    </div>
</div>

<!-- Chart.js script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('bookingChart').getContext('2d');
        
        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! $chartLabels !!},
                datasets: [{
                    label: 'Total Bookings',
                    data: {!! $chartData !!},
                    borderColor: 'rgb(79, 70, 229)',
                    backgroundColor: 'rgba(79, 70, 229, 0.1)',
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Booking Trend Over Time'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    });
</script>