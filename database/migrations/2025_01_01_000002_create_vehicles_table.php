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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('plate_number')->unique(); // Nomor polisi
            $table->string('type'); // Jenis kendaraan: mobil, truk, motor, dll
            $table->string('brand'); // Merk kendaraan
            $table->string('model'); // Model kendaraan
            $table->year('year'); // Tahun pembuatan
            $table->enum('category', ['personnel', 'cargo']); // Angkutan orang atau barang
            $table->enum('ownership', ['company', 'rental']); // Milik perusahaan atau rental
            $table->string('rental_company')->nullable(); // Jika rental, nama perusahaan rental
            $table->integer('capacity'); // Kapasitas kendaraan
            $table->string('fuel_type'); // Jenis bahan bakar
            $table->text('description')->nullable(); // Deskripsi kendaraan
            $table->enum('status', ['available', 'booked', 'maintenance', 'out_of_service'])->default('available');
            $table->date('last_service_date')->nullable(); // Tanggal service terakhir
            $table->integer('last_service_mileage')->nullable(); // Kilometer saat service terakhir
            $table->date('next_service_date')->nullable(); // Jadwal service berikutnya
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};