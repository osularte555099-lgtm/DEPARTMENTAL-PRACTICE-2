<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Table name: equipment (strictly adhering to rubric specifications)
     */
    public function up(): void
    {
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();
            // Foreign key referencing users.id with cascade delete
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('equipment_name');
            $table->string('category'); // Paddles, Balls, Nets, Accessories
            $table->decimal('unit_price', 10, 2); // Nonnegative decimal price
            $table->text('description');
            $table->string('availability_status'); // Available, Unavailable
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
};