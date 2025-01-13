<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\StatesEnum;
return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('car_id'); // Add the foreign key column
            $table->foreign('car_id')->references('id')->on('cars')->onDelete('cascade'); // Define the foreign key constraint
            $table->unsignedBigInteger('user_id'); // Add the foreign key column
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Define the foreign key constraint
            $table->timestamp('reservation_date');
            $table->enum('state', StatesEnum::toArray());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
