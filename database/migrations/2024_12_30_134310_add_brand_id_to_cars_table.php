<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->unsignedBigInteger('brand_id')->after('color'); // Add the foreign key column
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade'); // Define the foreign key constraint
            $table->dropColumn('brand');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->dropForeign(['brand_id']); // Drop the foreign key constraint
            $table->dropColumn('brand_id'); // Drop the column
        });
    }
};