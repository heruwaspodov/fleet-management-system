<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_code')->unique(); // Kode booking unik
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Pemohon booking
            $table->foreignId('vehicle_id')->constrained()->onDelete('cascade'); // Kendaraan yang dipesan
            $table->foreignId('driver_id')->nullable()->constrained('users')->onDelete('set null'); // Driver yang ditugaskan
            $table->text('purpose'); // Tujuan peminjaman
            $table->text('destination'); // Tujuan perjalanan
            $table->dateTime('start_datetime'); // Tanggal dan waktu mulai
            $table->dateTime('end_datetime'); // Tanggal dan waktu selesai
            $table->enum('status', [
                'draft',
                'pending_approval', 
                'approved', 
                'rejected', 
                'in_progress', 
                'completed', 
                'cancelled'
            ])->default('draft');
            $table->decimal('estimated_fuel_cost', 10, 2)->nullable(); // Estimasi biaya bensin
            $table->integer('estimated_distance')->nullable(); // Estimasi jarak tempuh (km)
            $table->text('notes')->nullable(); // Catatan tambahan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};