<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Booking Reports</h1>
        <p class="mt-2 text-gray-600">View and export booking reports</p>
    </div>

    <!-- Filters and Stats -->
    <div class="bg-white p-6 rounded-lg shadow border mb-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <div>
                <label for="startDate" class="block text-sm font-medium text-gray-700">Start Date</label>
                <input
                    type="date"
                    id="startDate"
                    wire:model="startDate"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 text-black">
            </div>
            <div>
                <label for="endDate" class="block text-sm font-medium text-gray-700">End Date</label>
                <input
                    type="date"
                    id="endDate"
                    wire:model="endDate"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 text-black">
            </div>
            <div class="flex items-end">
                <button
                    wire:click="exportToExcel"
                    class="w-full inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    Export to Excel
                </button>
            </div>
            <div class="flex items-end">
                <button
                    wire:click="loadReport"
                    class="w-full inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Refresh
                </button>
            </div>
        </div>

        <!-- Report Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-blue-50 p-4 rounded-lg">
                <p class="text-sm text-blue-800">Total Bookings</p>
                <p class="text-2xl font-bold text-blue-900">{{ $totalBookings }}</p>
            </div>
            <div class="bg-green-50 p-4 rounded-lg">
                <p class="text-sm text-green-800">Approved</p>
                <p class="text-2xl font-bold text-green-900">{{ $totalApproved }}</p>
            </div>
            <div class="bg-red-50 p-4 rounded-lg">
                <p class="text-sm text-red-800">Rejected</p>
                <p class="text-2xl font-bold text-red-900">{{ $totalRejected }}</p>
            </div>
            <div class="bg-purple-50 p-4 rounded-lg">
                <p class="text-sm text-purple-800">Completed</p>
                <p class="text-2xl font-bold text-purple-900">{{ $totalCompleted }}</p>
            </div>
        </div>
    </div>

    <!-- Booking Report Table -->
    <div class="bg-white shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Booking Code
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Requester
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Vehicle
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Driver
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Dates
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Created
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($bookings as $booking)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{ $booking->booking_code }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $booking->user->name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $booking->vehicle->plate_number }} - {{ $booking->vehicle->brand }} {{ $booking->vehicle->model }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $booking->driver ? $booking->driver->name : 'Not assigned' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                            @if($booking->status === 'pending_approval') bg-yellow-100 text-yellow-800
                            @elseif($booking->status === 'approved') bg-green-100 text-green-800
                            @elseif($booking->status === 'rejected') bg-red-100 text-red-800
                            @elseif($booking->status === 'in_progress') bg-blue-100 text-blue-800
                            @elseif($booking->status === 'completed') bg-purple-100 text-purple-800
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $booking->start_datetime->format('M d, Y H:i') }} - {{ $booking->end_datetime->format('M d, Y H:i') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $booking->created_at->format('M d, Y H:i') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                        No bookings found for the selected date range
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination and Controls -->
    <div class="mt-6 flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="flex items-center space-x-2">
            <label for="perPage" class="text-sm text-gray-700">Show</label>
            <select
                id="perPage"
                wire:model.live="perPage"
                class="border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
            <span class="text-sm text-gray-700">entries per page</span>
        </div>

        <div class="text-sm text-gray-700">
            Showing {{ $bookings->firstItem() }} to {{ $bookings->lastItem() }} of {{ $bookings->total() }} results
        </div>

        <div class="w-full md:w-auto">
            {{ $bookings->links() }}
        </div>
    </div>
</div>