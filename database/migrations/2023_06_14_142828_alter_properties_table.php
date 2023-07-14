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
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn('property_other_image_url');
        });
        Schema::table('properties', function (Blueprint $table) {
            $table->json('property_other_image_url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn('property_other_image_url');
        });
        Schema::table('properties', function (Blueprint $table) {
            $table->string('property_other_image_url');
        });
    }
};
