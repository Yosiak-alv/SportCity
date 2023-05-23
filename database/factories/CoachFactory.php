<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Coach>
 */
class CoachFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'dui' => fake()->unique()->numerify('########-#'),
            'name' => fake()->name(),
            'lastname' => fake()->lastName(),
            'email' =>fake()->unique()->email(),
            'phone' => fake()->numerify('#### ####'),
            'address' => fake()->address()
        ];
    }
}
