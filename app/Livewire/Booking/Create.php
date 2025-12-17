<?php

namespace App\Livewire\Booking;

use App\Models\User;
use App\Models\Vehicle;
use App\Models\Booking;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Create extends Component
{
    public $user_id;
    public $vehicle_id;
    public $driver_id;
    public $purpose;
    public $destination;
    public $start_datetime;
    public $end_datetime;
    public $estimated_fuel_cost;
    public $estimated_distance;
    public $notes;
    public $approver_ids = []; // Array untuk menyimpan ID approver berjenjang

    protected $rules = [
        'user_id' => 'required|exists:users,id',
        'vehicle_id' => 'required|exists:vehicles,id',
        'driver_id' => 'nullable|exists:users,id',
        'purpose' => 'required|string|max:255',
        'destination' => 'required|string|max:255',
        'start_datetime' => 'required|date|after_or_equal:today',
        'end_datetime' => 'required|date|after:start_datetime',
        'estimated_fuel_cost' => 'nullable|numeric|min:0',
        'estimated_distance' => 'nullable|integer|min:0',
        'notes' => 'nullable|string',
        'approver_ids' => 'required|array|min:2', // Minimal 2 level approval
        'approver_ids.*' => 'required|distinct|exists:users,id',
    ];

    public function mount()
    {
        // Set default values
        $this->start_datetime = now()->addDay()->format('Y-m-d\TH:i');
        $this->end_datetime = now()->addDays(2)->format('Y-m-d\TH:i');
    }

    public function render()
    {
        $users = User::where('role', '!=', 'admin')->get();
        $vehicles = Vehicle::where('status', 'available')->get();
        $drivers = User::where('role', 'employee')->get();
        $approvers = User::where('role', 'approver')->get();

        return view('livewire.booking.create', [
            'users' => $users,
            'vehicles' => $vehicles,
            'drivers' => $drivers,
            'approvers' => $approvers,
        ]);
    }

    public function save()
    {
        $this->validate();

        // Create the booking
        $booking = Booking::create([
            'user_id' => $this->user_id,
            'vehicle_id' => $this->vehicle_id,
            'driver_id' => $this->driver_id ?: null,
            'purpose' => $this->purpose,
            'destination' => $this->destination,
            'start_datetime' => $this->start_datetime,
            'end_datetime' => $this->end_datetime,
            'estimated_fuel_cost' => $this->estimated_fuel_cost,
            'estimated_distance' => $this->estimated_distance,
            'notes' => $this->notes,
            'status' => 'pending_approval', // Set status to pending approval initially
        ]);

        // Create approval requests for each level
        foreach ($this->approver_ids as $index => $approverId) {
            $booking->approvals()->create([
                'approver_id' => $approverId,
                'level' => $index + 1, // Level starts from 1
                'status' => 'pending',
            ]);
        }

        session()->flash('message', 'Booking created successfully.');

        // Redirect to booking index or show success
        return $this->redirect('/bookings', navigate: true);
    }
}
