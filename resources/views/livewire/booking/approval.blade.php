<div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow">
    <h1 class="text-2xl font-bold mb-6">Booking Approval</h1>

    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-{{ strpos(session('message'), 'approved') !== false ? 'green' : 'red' }}-100 text-{{ strpos(session('message'), 'approved') !== false ? 'green' : 'red' }}-700 rounded">
            {{ session('message') }}
        </div>
    @endif

    @if($booking && $approval)
    <div class="mb-6 bg-gray-50 p-4 rounded-lg">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <h3 class="font-medium text-gray-900">Booking Information</h3>
                <p class="text-sm text-gray-600">Code: {{ $booking->booking_code }}</p>
                <p class="text-sm text-gray-600">Requester: {{ $booking->user->name }}</p>
                <p class="text-sm text-gray-600">Purpose: {{ $booking->purpose }}</p>
                <p class="text-sm text-gray-600">Destination: {{ $booking->destination }}</p>
            </div>
            <div>
                <h3 class="font-medium text-gray-900">Vehicle Information</h3>
                <p class="text-sm text-gray-600">Plate: {{ $booking->vehicle->plate_number }}</p>
                <p class="text-sm text-gray-600">Type: {{ $booking->vehicle->type }}</p>
                <p class="text-sm text-gray-600">Brand: {{ $booking->vehicle->brand }} {{ $booking->vehicle->model }}</p>
            </div>
        </div>
        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <h3 class="font-medium text-gray-900">Schedule</h3>
                <p class="text-sm text-gray-600">Start: {{ $booking->start_datetime->format('d M Y H:i') }}</p>
                <p class="text-sm text-gray-600">End: {{ $booking->end_datetime->format('d M Y H:i') }}</p>
            </div>
            <div>
                <h3 class="font-medium text-gray-900">Approval Details</h3>
                <p class="text-sm text-gray-600">Level: {{ $approval->level }}</p>
                <p class="text-sm text-gray-600">Status: <span class="font-bold">{{ ucfirst($approval->status) }}</span></p>
            </div>
        </div>
    </div>

    @if($approval->status === 'pending')
    <form wire:submit="submitApproval" class="space-y-6">
        <div>
            <label class="block text-sm font-medium text-gray-700">Approval Decision</label>
            <div class="mt-2 space-y-3">
                <div class="flex items-center">
                    <input
                        type="radio"
                        id="approve"
                        value="approved"
                        wire:model="status"
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                    <label for="approve" class="ml-2 block text-sm text-gray-900">
                        Approve
                    </label>
                </div>
                <div class="flex items-center">
                    <input
                        type="radio"
                        id="reject"
                        value="rejected"
                        wire:model="status"
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                    <label for="reject" class="ml-2 block text-sm text-gray-900">
                        Reject
                    </label>
                </div>
            </div>
            @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="comment" class="block text-sm font-medium text-gray-700">Comment (Optional)</label>
            <textarea
                id="comment"
                wire:model="comment"
                rows="3"
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"></textarea>
            @error('comment') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('my-approvals') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Cancel
            </a>
            <button
                type="submit"
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Submit Approval
            </button>
        </div>
    </form>
    @else
        <div class="p-4 bg-yellow-50 rounded-lg">
            <p class="text-yellow-700">This approval has already been processed.</p>
        </div>
    @endif
    @endif
</div>
