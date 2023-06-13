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
        Schema::create('property', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_id')->references('id')->on('products')->cascadeOnDelete();
            $table->string('property_name');
            $table->string('property_address');
            $table->double('property_price');
            $table->string('property_category');
            $table->paragraph('property_description');
            $table->integer('property_stock');
            $table->double('property_total_floor_area') .' cm^2';
            $table->integer('property_bedroom_number');
            $table->integer('property_toilet_number');
            $table->url('property_plan_image_url');
            $table->url('property_other_image_url');
            $table->string('owner_id');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property');
    }
};
