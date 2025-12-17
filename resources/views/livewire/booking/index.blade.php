<div class="max-w-6xl mx-auto p-6 bg-white rounded-lg shadow">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Bookings</h1>
        @if(auth()->user()->isAdmin())
            <a href="{{ route('booking.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Create Booking
            </a>
        @endif
    </div>

    <div class="mb-6 flex flex-col sm:flex-row gap-4">
        <div class="flex-1">
            <input
                type="text"
                wire:model.live="search"
                placeholder="Search bookings..."
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <select
            wire:model.live="status"
            class="px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            <option value="">All Status</option>
            <option value="draft">Draft</option>
            <option value="pending_approval">Pending Approval</option>
            <option value="approved">Approved</option>
            <option value="rejected">Rejected</option>
            <option value="in_progress">In Progress</option>
            <option value="completed">Completed</option>
            <option value="cancelled">Cancelled</option>
        </select>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th
                        scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                        wire:click="sortBy('booking_code')">
                        <div class="flex items-center">
                            <span>Booking Code</span>
                            @if($sortBy === 'booking_code')
                                <span>{!! $sortDirection === 'asc' ? '↑' : '↓' !!}</span>
                            @endif
                        </div>
                    </th>
                    <th
                        scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                        wire:click="sortBy('created_at')">
                        <div class="flex items-center">
                            <span>Date</span>
                            @if($sortBy === 'created_at')
                                <span>{!! $sortDirection === 'asc' ? '↑' : '↓' !!}</span>
                            @endif
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Requester
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Driver
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Vehicle
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Purpose
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Schedule
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($bookings as $booking)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $booking->booking_code }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">{{ $booking->created_at->format('d M Y') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $booking->user->name }}</div>
                            <div class="text-sm text-gray-500">{{ $booking->user->department }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($booking->driver)
                                <div class="text-sm text-gray-900">{{ $booking->driver->name }}</div>
                            @else
                                <div class="text-sm text-gray-500">Not assigned</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $booking->vehicle->plate_number }}</div>
                            <div class="text-sm text-gray-500">{{ $booking->vehicle->brand }} {{ $booking->vehicle->model }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900 max-w-xs truncate" title="{{ $booking->purpose }}">{{ $booking->purpose }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $booking->start_datetime->format('d M Y H:i') }}</div>
                            <div class="text-sm text-gray-500">{{ $booking->end_datetime->format('d M Y H:i') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($booking->status === 'draft') bg-gray-100 text-gray-800
                                @elseif($booking->status === 'pending_approval') bg-yellow-100 text-yellow-800
                                @elseif($booking->status === 'approved') bg-green-100 text-green-800
                                @elseif($booking->status === 'rejected') bg-red-100 text-red-800
                                @elseif($booking->status === 'in_progress') bg-blue-100 text-blue-800
                                @elseif($booking->status === 'completed') bg-purple-100 text-purple-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('booking.show', $booking->id) }}"
                               class="text-indigo-600 hover:text-indigo-900 mr-3">
                                View
                            </a>

                            @if($booking->isDraft() && (auth()->user()->isAdmin() || auth()->user()->id === $booking->user_id))
                                <a href="{{ route('booking.edit', $booking->id) }}"
                                   class="text-green-600 hover:text-green-900 mr-3">
                                    Edit
                                </a>

                                <button
                                    wire:click="delete({{ $booking->id }})"
                                    class="text-red-600 hover:text-red-900">
                                    Delete
                                </button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-6 py-4 text-center text-sm text-gray-500">
                            No bookings found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $bookings->links() }}
    </div>
</div>
