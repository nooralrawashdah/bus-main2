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
            $table->foreignId('trip_id')->constrained('trips')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('bus_seat_id')->constrained('bus_seats')->onDelete('cascade');
            $table->unique(['trip_id', 'bus_seat_id']);  // منع حجز نفس المقعد مرتين بنفس الرحلة
            $table->unique(['trip_id', 'user_id']);      // منع حجز مقعد ثاني لنفس المستخدم بنفس الرحلة
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
