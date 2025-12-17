@php
use Illuminate\Support\Str;
@endphp

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Approval Requests</h1>
        <p class="mt-2 text-gray-600">Manage booking approval requests</p>
    </div>

    <!-- Filters -->
    <div class="bg-white p-6 rounded-lg shadow border mb-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                <input
                    type="text"
                    id="search"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Search by code, user, or vehicle"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 text-black">
            </div>
            <div>
                <label for="startDate" class="block text-sm font-medium text-gray-700">Start Date</label>
                <input
                    type="date"
                    id="startDateFilter"
                    wire:model.live="startDate"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 text-black">
            </div>
            <div>
                <label for="endDate" class="block text-sm font-medium text-gray-700">End Date</label>
                <input
                    type="date"
                    id="endDateFilter"
                    wire:model.live="endDate"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 text-black">
            </div>
            <div class="flex items-end space-x-3">
                <div>
                    <label for="statusFilter" class="block text-sm font-medium text-gray-700">Status</label>
                    <select
                        id="statusFilter"
                        wire:model.live="statusFilter"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 text-black">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-6">
            <div>
                <label for="levelFilter" class="block text-sm font-medium text-gray-700">Level</label>
                <select
                    id="levelFilter"
                    wire:model.live="levelFilter"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 text-black">
                    <option value="">All Levels</option>
                    <option value="1">Level 1</option>
                    <option value="2">Level 2</option>
                    <option value="3">Level 3</option>
                </select>
            </div>
            <div>
                <label for="perPage" class="block text-sm font-medium text-gray-700">Entries Per Page</label>
                <select
                    id="perPage"
                    wire:model.live="perPage"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-black">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Approval Requests Table -->
    <div class="bg-white shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Code
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
                        Purpose
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Dates
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($bookings as $booking)
                <tr>
                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900 max-w-xs">
                        {{ $booking->booking_code }}
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 max-w-xs">
                        {{ $booking->user->name }}
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 max-w-xs">
                        {{ $booking->vehicle->plate_number }}<br><span class="text-xs">{{ $booking->vehicle->brand }} {{ $booking->vehicle->model }}</span>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 max-w-xs">
                        {{ $booking->driver ? $booking->driver->name : 'Not assigned' }}
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-500 max-w-xs truncate" title="{{ $booking->purpose }}">
                        {{ Str::limit($booking->purpose, 20, '...') }}
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 max-w-xs">
                        {{ $booking->start_datetime->format('m/d') }} - {{ $booking->end_datetime->format('m/d') }}
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap max-w-xs">
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
                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                        <div class="flex flex-col space-y-1 md:flex-row md:space-y-0 md:space-x-2">
                            <button
                                wire:click="approve({{ $booking->id }})"
                                class="text-green-600 hover:text-green-900 text-xs md:text-sm">
                                Approve
                            </button>
                            <button
                                wire:click="reject({{ $booking->id }})"
                                class="text-red-600 hover:text-red-900 text-xs md:text-sm">
                                Reject
                            </button>
                            <a href="{{ route('booking.show', ['id' => $booking->id]) }}" class="text-blue-600 hover:text-blue-900 text-xs md:text-sm">
                                View
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">
                        No approval requests found
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6 flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="text-sm text-gray-700">
            Showing {{ $bookings->firstItem() }} to {{ $bookings->lastItem() }} of {{ $bookings->total() }} results
        </div>
        
        <div class="w-full md:w-auto">
            {{ $bookings->links() }}
        </div>
    </div>
</div>