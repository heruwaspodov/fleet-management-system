<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Approval>
 */
class ApprovalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $statuses = ['pending', 'approved', 'rejected'];
        
        return [
            'booking_id' => \App\Models\Booking::factory(),
            'approver_id' => \App\Models\User::factory()->approver(),
            'level' => fake()->numberBetween(1, 3),
            'status' => fake()->randomElement($statuses),
            'comments' => fake()->optional()->sentence(),
            'approved_at' => fake()->optional()->dateTime(),
        ];
    }
}