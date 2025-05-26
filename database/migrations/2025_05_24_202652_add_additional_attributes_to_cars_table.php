<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('cars', function (Blueprint $table) {

            if (!Schema::hasColumn('cars', 'created_by_id')) {
                $table->foreignId('created_by_id')->nullable()->constrained('users')->nullOnDelete();
            }

            if (!Schema::hasColumn('cars', 'brand_id')) {
                $table->foreignId('brand_id')->nullable()->constrained('brands')->nullOnDelete();
            }

            if (!Schema::hasColumn('cars', 'km_recorded')) {
                $table->integer('km_recorded')->nullable();
            }

            // Basic & Performance Specs
            if (!Schema::hasColumn('cars', 'transmission'))
                $table->string('transmission')->nullable();
            if (!Schema::hasColumn('cars', 'engine_type'))
                $table->string('engine_type')->nullable();
            if (!Schema::hasColumn('cars', 'engine_size'))
                $table->string('engine_size')->nullable();
            if (!Schema::hasColumn('cars', 'horsepower'))
                $table->integer('horsepower')->nullable();
            if (!Schema::hasColumn('cars', 'torque'))
                $table->integer('torque')->nullable();
            if (!Schema::hasColumn('cars', 'drivetrain'))
                $table->string('drivetrain')->nullable();
            if (!Schema::hasColumn('cars', 'fuel_type'))
                $table->string('fuel_type')->nullable();
            if (!Schema::hasColumn('cars', 'fuel_economy'))
                $table->string('fuel_economy')->nullable();

            // Features & Options
            if (!Schema::hasColumn('cars', 'body_type'))
                $table->string('body_type')->nullable();
            if (!Schema::hasColumn('cars', 'seats'))
                $table->integer('seats')->nullable();
            if (!Schema::hasColumn('cars', 'doors'))
                $table->integer('doors')->nullable();
            if (!Schema::hasColumn('cars', 'interior_color'))
                $table->string('interior_color')->nullable();
            if (!Schema::hasColumn('cars', 'features'))
                $table->json('features')->nullable(); // Store options like sunroof, GPS, etc.
            if (!Schema::hasColumn('cars', 'safety_rating'))
                $table->string('safety_rating')->nullable();

            // History & Condition
            if (!Schema::hasColumn('cars', 'condition'))
                $table->string('condition')->nullable(); // e.g. New, Used, Excellent
            if (!Schema::hasColumn('cars', 'service_history'))
                $table->text('service_history')->nullable();
            if (!Schema::hasColumn('cars', 'accident_history'))
                $table->text('accident_history')->nullable();
            if (!Schema::hasColumn('cars', 'ownership_count'))
                $table->integer('ownership_count')->nullable();
            if (!Schema::hasColumn('cars', 'registration_valid_till'))
                $table->date('registration_valid_till')->nullable();

            // Location & Logistics
            if (!Schema::hasColumn('cars', 'location'))
                $table->string('location')->nullable();
            if (!Schema::hasColumn('cars', 'delivery_available'))
                $table->boolean('delivery_available')->nullable();
            if (!Schema::hasColumn('cars', 'available_from'))
                $table->date('available_from')->nullable();

            // Media & Documentation
            if (!Schema::hasColumn('cars', 'video'))
                $table->string('video')->nullable();
            if (!Schema::hasColumn('cars', 'documents'))
                $table->json('documents')->nullable();
            if (!Schema::hasColumn('cars', 'gallery_images'))
                $table->json('gallery_images')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $columns = [
                'created_by_id',
                'brand_id',
                'km_recorded',
                'transmission',
                'engine_type',
                'engine_size',
                'horsepower',
                'torque',
                'drivetrain',
                'fuel_type',
                'fuel_economy',
                'body_type',
                'seats',
                'doors',
                'interior_color',
                'features',
                'safety_rating',
                'condition',
                'service_history',
                'accident_history',
                'ownership_count',
                'registration_valid_till',
                'location',
                'delivery_available',
                'available_from',
                'video',
                'documents',
                'gallery_images',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('cars', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
