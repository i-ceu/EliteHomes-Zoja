<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Property;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */


    public function definition(): array
    {
        $property = Property::factory()->create();
        $user = User::factory()->create();

        return [
            'name' => fake()->name(),
            'email' => fake()->email(),
            'message' => fake()->sentence(),
            'phone_number' => fake()->phoneNumber(),
            'sender_id' => $user?->id,
            'property_id' => $property->id,
        ];
    }
}
