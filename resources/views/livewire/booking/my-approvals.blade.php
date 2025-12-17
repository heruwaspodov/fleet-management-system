<div class="max-w-6xl mx-auto p-6 bg-white rounded-lg shadow">
    <h1 class="text-2xl font-bold mb-6">My Approvals</h1>

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
            <option value="pending">Pending</option>
            <option value="approved">Approved</option>
            <option value="rejected">Rejected</option>
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
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Level
                    </th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($approvals as $approval)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $approval->booking->booking_code }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">{{ $approval->booking->created_at->format('d M Y') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $approval->booking->user->name }}</div>
                            <div class="text-sm text-gray-500">{{ $approval->booking->user->department }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $approval->booking->vehicle->plate_number }}</div>
                            <div class="text-sm text-gray-500">{{ $approval->booking->vehicle->brand }} {{ $approval->booking->vehicle->model }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900 max-w-xs truncate" title="{{ $approval->booking->purpose }}">{{ $approval->booking->purpose }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $approval->booking->start_datetime->format('d M Y H:i') }}</div>
                            <div class="text-sm text-gray-500">{{ $approval->booking->end_datetime->format('d M Y H:i') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($approval->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($approval->status === 'approved') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($approval->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            Level {{ $approval->level }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            @if($approval->status === 'pending')
                                <a href="{{ route('booking.approval', $approval->booking->id) }}"
                                   class="text-indigo-600 hover:text-indigo-900">
                                    Review
                                </a>
                            @else
                                <span class="text-gray-400">Completed</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-6 py-4 text-center text-sm text-gray-500">
                            No approvals found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $approvals->links() }}
    </div>
</div>
