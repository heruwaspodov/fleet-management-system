<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'role' => fake()->randomElement(['admin', 'approver', 'employee']),
            'approval_level' => fake()->numberBetween(1, 3),
            'position' => fake()->jobTitle(),
            'department' => fake()->randomElement(['Operations', 'Logistics', 'Mining', 'HR', 'Finance', 'Maintenance']),
            'phone' => fake()->phoneNumber(),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Set the user role to admin
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
            'approval_level' => 0, // Admin tidak perlu approval
        ]);
    }

    /**
     * Set the user role to approver
     */
    public function approver(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'approver',
            'approval_level' => fake()->numberBetween(1, 3),
        ]);
    }

    /**
     * Set the user role to employee
     */
    public function employee(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'employee',
            'approval_level' => 0,
        ]);
    }

    /**
     * Set the user without two factor authentication
     */
    public function withoutTwoFactor(): static
    {
        return $this->state(fn (array $attributes) => [
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'two_factor_confirmed_at' => null,
        ]);
    }

    /**
     * Set the user without two factor authentication (alternative method name)
     */
    public function withoutTwoFactorAuthentication(): static
    {
        return $this->withoutTwoFactor();
    }
}