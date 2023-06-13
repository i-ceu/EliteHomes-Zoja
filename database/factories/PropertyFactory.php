<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Property>
 */
class PropertyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fake()->uuid(),
            'property_name' => fake()->name(),
            'property_address' => fake()->paragraph(),
            'property_price' => fake()->numberBetween(100, 1000),
            'property_category' => fake()->numberBetween(1, 7),
            'property_description' => fake()->paragraph(),
            'property_stock' => fake()->shuffleString(),
            'property_total_floor_area' => fake()->numberBetween(10, 20) . ' cm^2',
            'property_bedroom_number' => fake()->numberBetween(0, 5),
            'property_toilet_number' => fake()->numberBetween(0, 3),
            'property_plan_image_url' => fake()->url(),
            'property_other_image_url' => fake()->url(),
        ];
    }
}
