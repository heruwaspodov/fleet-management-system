<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['Car', 'Truck', 'Van', 'Bus', 'Motorcycle', 'Heavy Equipment'];
        $brands = ['Toyota', 'Honda', 'Ford', 'Chevrolet', 'Mercedes', 'Volvo', 'Caterpillar', 'Komatsu'];
        $fuelTypes = ['Gasoline', 'Diesel', 'Electric', 'Hybrid'];
        $categories = ['personnel', 'cargo'];
        $ownership = ['company', 'rental'];
        
        return [
            'plate_number' => strtoupper(fake()->bothify('???-####')),
            'type' => fake()->randomElement($types),
            'brand' => fake()->randomElement($brands),
            'model' => fake()->word(),
            'year' => fake()->year(),
            'category' => fake()->randomElement($categories),
            'ownership' => fake()->randomElement($ownership),
            'rental_company' => fake()->company(),
            'capacity' => fake()->numberBetween(2, 50),
            'fuel_type' => fake()->randomElement($fuelTypes),
            'description' => fake()->sentence(),
            'status' => fake()->randomElement(['available', 'booked', 'maintenance', 'out_of_service']),
            'last_service_date' => fake()->dateTimeBetween('-1 year', 'now'),
            'last_service_mileage' => fake()->numberBetween(10000, 100000),
            'next_service_date' => fake()->dateTimeBetween('now', '+3 months'),
        ];
    }
}