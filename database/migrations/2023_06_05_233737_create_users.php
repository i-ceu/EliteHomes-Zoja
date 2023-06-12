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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('username')->unique();
            $table->string('email')
                ->unique()
                ->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('profile_picture');
            $table->string('password');
            $table->string('confirm_password');
            $table->string('phone_number');
            $table->boolean('is_landlord');
            $table->boolean('is_admin')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
