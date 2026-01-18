<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void // poofet table 
    {
        Schema::create('bus_seats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bus_id')->constrained('buses')->onDelete('cascade');
            $table->foreignId('seat_id')->constrained('seats')->onDelete('cascade');
            $table->unique(['bus_id', 'seat_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bus_seats');
    }
};
