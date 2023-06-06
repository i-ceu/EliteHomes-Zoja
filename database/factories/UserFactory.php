<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{

    public $length = 9;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => fake()->unique()->randomNumber($this->length),
            'username' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            // 'email_verified_at' => now(),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'password' => fake()->password(),
            'confirm_password' => fake()->password(),
            'phone_number' => fake()->phoneNumber(),
            'isLandlord' => fake()->boolean,
            'isAdmin' => fake()->boolean,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
