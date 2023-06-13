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
        Schema::create('properties', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignUuid('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('property_name');
            $table->string('property_address');
            $table->double('property_price');
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->longText('property_description');
            $table->integer('property_stock');
            $table->double('property_total_floor_area');
            $table->integer('property_bedroom_number');
            $table->integer('property_toilet_number');
            $table->string('property_plan_image_url');
            $table->string('property_other_image_url');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
