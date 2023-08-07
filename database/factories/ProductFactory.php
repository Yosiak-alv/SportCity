<?php

namespace Database\Factories;

use App\Models\Gym;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gym = Gym::inRandomOrder()->limit(1)->first();
        return [
            'uuid' => \Illuminate\Support\Str::uuid(),
            'name' => fake()->word(),
            'description' => fake()->paragraph(),
            'unit_price' => fake()->randomFloat(2,5,500),
            'quantity' => fake()->randomDigitNotZero(),
            'gym_id' => $gym ->id
            
        ];
    }
}
