<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $statuses = ['draft', 'pending_approval', 'approved', 'rejected', 'in_progress', 'completed', 'cancelled'];
        
        return [
            'user_id' => \App\Models\User::factory(),
            'vehicle_id' => \App\Models\Vehicle::factory(),
            'driver_id' => \App\Models\User::factory()->employee(),
            'purpose' => fake()->sentence(),
            'destination' => fake()->address(),
            'start_datetime' => fake()->dateTimeBetween('+1 day', '+1 week'),
            'end_datetime' => fake()->dateTimeBetween('+2 day', '+2 week'),
            'status' => fake()->randomElement($statuses),
            'estimated_fuel_cost' => fake()->randomFloat(2, 50, 500),
            'estimated_distance' => fake()->numberBetween(50, 500),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}