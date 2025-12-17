<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vehicle;
use App\Models\Booking;
use App\Models\Approval;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::factory()->admin()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'position' => 'System Administrator',
            'department' => 'IT',
        ]);

        // Create approvers
        User::factory()->approver()->create([
            'name' => 'First Level Approver',
            'email' => 'approver1@example.com',
            'password' => bcrypt('password'),
            'position' => 'Department Head',
            'department' => 'Operations',
            'approval_level' => 1,
        ]);

        User::factory()->approver()->create([
            'name' => 'Second Level Approver',
            'email' => 'approver2@example.com',
            'password' => bcrypt('password'),
            'position' => 'Manager',
            'department' => 'Operations',
            'approval_level' => 2,
        ]);

        User::factory()->approver()->create([
            'name' => 'Third Level Approver',
            'email' => 'approver3@example.com',
            'password' => bcrypt('password'),
            'position' => 'Director',
            'department' => 'Operations',
            'approval_level' => 3,
        ]);

        // Create regular employees
        User::factory(5)->employee()->create();

        // Create vehicles
        Vehicle::factory(10)->create();

        // Create bookings and approvals
        Booking::factory(20)->create()->each(function ($booking) {
            // Create approvals for pending/approved bookings
            if (in_array($booking->status, ['pending_approval', 'approved', 'rejected'])) {
                $approver = User::where('role', 'approver')->get();
                
                // Create first level approval
                Approval::factory()->create([
                    'booking_id' => $booking->id,
                    'approver_id' => $approver->firstWhere('approval_level', 1)?->id ?? $approver->first()->id,
                    'level' => 1,
                ]);
                
                // Sometimes create second level approval
                if (fake()->boolean(70)) {
                    Approval::factory()->create([
                        'booking_id' => $booking->id,
                        'approver_id' => $approver->firstWhere('approval_level', 2)?->id ?? $approver->skip(1)->first()->id,
                        'level' => 2,
                    ]);
                }
                
                // Sometimes create third level approval
                if (fake()->boolean(40)) {
                    Approval::factory()->create([
                        'booking_id' => $booking->id,
                        'approver_id' => $approver->firstWhere('approval_level', 3)?->id ?? $approver->skip(2)->first()->id,
                        'level' => 3,
                    ]);
                }
            }
        });
    }
}