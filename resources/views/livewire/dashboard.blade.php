<div class="flex h-full w-full flex-1 flex-col gap-6 px-4 py-6">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Dashboard</h1>
        <p class="mt-2 text-gray-600 dark:text-gray-300">Welcome back! Here's an overview of your fleet management system.</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-blue-100 dark:bg-blue-900/50">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($totalBookings) }}</h3>
                    <p class="text-gray-500 dark:text-gray-400">Total Bookings</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-yellow-100 dark:bg-yellow-900/50">
                    <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($pendingBookings) }}</h3>
                    <p class="text-gray-500 dark:text-gray-400">Pending Approval</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-green-100 dark:bg-green-900/50">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($approvedBookings) }}</h3>
                    <p class="text-gray-500 dark:text-gray-400">Approved</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-purple-100 dark:bg-purple-900/50">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.227 7.417l1.565 1.566a5.998 5.998 0 103.585 3.585l1.566 1.565a7.002 7.002 0 01-9.9 0 7.002 7.002 0 010-9.9z"></path>
                        <path d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($totalVehicles) }}</h3>
                    <p class="text-gray-500 dark:text-gray-400">Total Vehicles</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-red-100 dark:bg-red-900/50">
                    <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($rejectedBookings) }}</h3>
                    <p class="text-gray-500 dark:text-gray-400">Rejected</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-indigo-100 dark:bg-indigo-900/50">
                    <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($totalUsers) }}</h3>
                    <p class="text-gray-500 dark:text-gray-400">Total Users</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Vehicle Status Distribution -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow border border-gray-200 dark:border-gray-700">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Vehicle Status</h2>
            <div class="space-y-4">
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-base font-medium text-gray-700 dark:text-gray-300">Available</span>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $availableVehicles }}/{{ $totalVehicles }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                        <div class="bg-green-600 h-2.5 rounded-full" style="width: {{ $totalVehicles > 0 ? round(($availableVehicles / $totalVehicles) * 100, 2) : 0 }}%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-base font-medium text-gray-700 dark:text-gray-300">Booked</span>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $bookedVehicles }}/{{ $totalVehicles }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $totalVehicles > 0 ? round(($bookedVehicles / $totalVehicles) * 100, 2) : 0 }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Booking Status -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow border border-gray-200 dark:border-gray-700">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Booking Status</h2>
            <div class="space-y-4">
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-base font-medium text-gray-700 dark:text-gray-300">Approved</span>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $approvedBookings }}/{{ $totalBookings }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                        <div class="bg-green-600 h-2.5 rounded-full" style="width: {{ $totalBookings > 0 ? round(($approvedBookings / $totalBookings) * 100, 2) : 0 }}%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-base font-medium text-gray-700 dark:text-gray-300">Pending</span>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $pendingBookings }}/{{ $totalBookings }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                        <div class="bg-yellow-600 h-2.5 rounded-full" style="width: {{ $totalBookings > 0 ? round(($pendingBookings / $totalBookings) * 100, 2) : 0 }}%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-base font-medium text-gray-700 dark:text-gray-300">Completed</span>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $completedBookings }}/{{ $totalBookings }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                        <div class="bg-purple-600 h-2.5 rounded-full" style="width: {{ $totalBookings > 0 ? round(($completedBookings / $totalBookings) * 100, 2) : 0 }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Recent Bookings Chart -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow border border-gray-200 dark:border-gray-700">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Bookings Last 7 Days</h2>
            <div class="space-y-3">
                @forelse($bookingChart as $day)
                    <div class="flex items-center">
                        <div class="w-16 text-sm text-gray-500 dark:text-gray-400">{{ $day['day'] }}</div>
                        <div class="flex-1">
                            <div class="w-full bg-gray-200 rounded-full h-4 dark:bg-gray-700">
                                <div class="bg-indigo-600 h-4 rounded-full text-center text-xs text-white" style="width: {{ max($day['count'] * 10, 1) }}%">
                                    {{ $day['count'] }}
                                </div>
                            </div>
                        </div>
                        <div class="w-12 text-right text-sm text-gray-500 dark:text-gray-400">{{ $day['count'] }}</div>
                    </div>
                @empty
                    <p class="text-gray-500 dark:text-gray-400 text-center py-4">No data available</p>
                @endforelse
            </div>
        </div>

        <!-- Top Vehicles Used -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow border border-gray-200 dark:border-gray-700">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Top Vehicles Used</h2>
            @if(!empty($vehicleUsageChart))
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                    @foreach($vehicleUsageChart as $vehicle)
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 text-center">
                            <div class="text-lg font-bold text-gray-900 dark:text-white">{{ $vehicle['vehicle'] }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $vehicle['bookings'] }} bookings</div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 dark:text-gray-400 text-center py-4">No vehicle usage data available</p>
            @endif
        </div>
    </div>
</div>