<div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow">
    <h1 class="text-2xl font-bold mb-6">Create New Booking</h1>

    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit="save" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Requester -->
            <div>
                <label for="user_id" class="block text-sm font-medium text-gray-700">Requester</label>
                <select
                    id="user_id"
                    wire:model="user_id"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Select Requester</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->department }})</option>
                    @endforeach
                </select>
                @error('user_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Vehicle -->
            <div>
                <label for="vehicle_id" class="block text-sm font-medium text-gray-700">Vehicle</label>
                <select
                    id="vehicle_id"
                    wire:model="vehicle_id"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Select Vehicle</option>
                    @foreach($vehicles as $vehicle)
                        <option value="{{ $vehicle->id }}">{{ $vehicle->plate_number }} - {{ $vehicle->brand }} {{ $vehicle->model }}</option>
                    @endforeach
                </select>
                @error('vehicle_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Driver -->
            <div>
                <label for="driver_id" class="block text-sm font-medium text-gray-700">Driver</label>
                <select
                    id="driver_id"
                    wire:model="driver_id"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Select Driver (Optional)</option>
                    @foreach($drivers as $driver)
                        <option value="{{ $driver->id }}">{{ $driver->name }}</option>
                    @endforeach
                </select>
                @error('driver_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Purpose -->
            <div>
                <label for="purpose" class="block text-sm font-medium text-gray-700">Purpose</label>
                <input
                    type="text"
                    id="purpose"
                    wire:model="purpose"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                @error('purpose') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Destination -->
            <div>
                <label for="destination" class="block text-sm font-medium text-gray-700">Destination</label>
                <input
                    type="text"
                    id="destination"
                    wire:model="destination"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                @error('destination') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Start Date/Time -->
            <div>
                <label for="start_datetime" class="block text-sm font-medium text-gray-700">Start Date & Time</label>
                <input
                    type="datetime-local"
                    id="start_datetime"
                    wire:model="start_datetime"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                @error('start_datetime') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- End Date/Time -->
            <div>
                <label for="end_datetime" class="block text-sm font-medium text-gray-700">End Date & Time</label>
                <input
                    type="datetime-local"
                    id="end_datetime"
                    wire:model="end_datetime"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                @error('end_datetime') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Estimated Fuel Cost -->
            <div>
                <label for="estimated_fuel_cost" class="block text-sm font-medium text-gray-700">Estimated Fuel Cost</label>
                <input
                    type="number"
                    id="estimated_fuel_cost"
                    wire:model="estimated_fuel_cost"
                    step="0.01"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                @error('estimated_fuel_cost') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Estimated Distance -->
            <div>
                <label for="estimated_distance" class="block text-sm font-medium text-gray-700">Estimated Distance (km)</label>
                <input
                    type="number"
                    id="estimated_distance"
                    wire:model="estimated_distance"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                @error('estimated_distance') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Approvers -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700">Approvers (Minimum 2 Levels)</label>
                <div class="mt-2 space-y-3">
                    @foreach($approvers as $index => $approver)
                        <div class="flex items-center">
                            <input
                                type="checkbox"
                                id="approver_{{ $approver->id }}"
                                value="{{ $approver->id }}"
                                wire:model="approver_ids"
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="approver_{{ $approver->id }}" class="ml-2 block text-sm text-gray-900">
                                {{ $approver->name }} (Level {{ $approver->approval_level }} - {{ $approver->position }})
                            </label>
                        </div>
                    @endforeach
                </div>
                @error('approver_ids') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Notes -->
            <div class="md:col-span-2">
                <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                <textarea
                    id="notes"
                    wire:model="notes"
                    rows="3"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                @error('notes') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('bookings.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Cancel
            </a>
            <button
                type="submit"
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Create Booking
            </button>
        </div>
    </form>
</div>
