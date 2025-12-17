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
        Schema::create('vehicle_usage_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->onDelete('cascade'); // ID booking terkait
            $table->foreignId('vehicle_id')->constrained()->onDelete('cascade'); // ID kendaraan
            $table->foreignId('driver_id')->constrained('users')->onDelete('cascade'); // ID driver
            $table->dateTime('actual_start_datetime')->nullable(); // Waktu mulai sebenarnya
            $table->dateTime('actual_end_datetime')->nullable(); // Waktu selesai sebenarnya
            $table->integer('starting_odometer')->nullable(); // Odometer awal
            $table->integer('ending_odometer')->nullable(); // Odometer akhir
            $table->decimal('fuel_used', 10, 2)->nullable(); // Bensin yang digunakan
            $table->decimal('fuel_cost', 10, 2)->nullable(); // Biaya bensin yang dikeluarkan
            $table->text('condition_on_departure')->nullable(); // Kondisi kendaraan saat berangkat
            $table->text('condition_on_return')->nullable(); // Kondisi kendaraan saat kembali
            $table->text('notes')->nullable(); // Catatan tambahan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_usage_logs');
    }
};