<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->json('features')->nullable()->change();
            $table->json('documents')->nullable()->change();
            $table->json('gallery_images')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->longText('features')->nullable()->change();
            $table->longText('documents')->nullable()->change();
            $table->longText('gallery_images')->nullable()->change();
        });
    }
};
