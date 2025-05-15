<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLikesTable extends Migration
{
    public function up()
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('car_id')->constrained()->onDelete('cascade');
            $table->decimal('like', 3, 2)->default(1.00); // decimal for future average; default liked
            $table->timestamps();

            $table->unique(['user_id', 'car_id']); // user can like a car only once
        });
    }

    public function down()
    {
        Schema::dropIfExists('likes');
    }
}

