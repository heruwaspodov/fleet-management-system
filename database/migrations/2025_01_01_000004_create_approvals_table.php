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
        Schema::create('approvals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->onDelete('cascade'); // ID booking
            $table->foreignId('approver_id')->constrained('users')->onDelete('cascade'); // ID approver
            $table->unsignedBigInteger('level'); // Level approval (1, 2, 3, dst)
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('comments')->nullable(); // Komentar dari approver
            $table->timestamp('approved_at')->nullable(); // Waktu approve/reject
            $table->timestamps();
            
            // Pastikan tidak ada duplikasi approval untuk level yang sama pada booking yang sama
            $table->unique(['booking_id', 'level']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approvals');
    }
};