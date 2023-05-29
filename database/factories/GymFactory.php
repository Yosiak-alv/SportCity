<?php

namespace Database\Factories;

use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Gym>
 */
class GymFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $department = Department::inRandomOrder()->limit(1)->first();
        return [
            'name' => fake()->name(),
            'address' => fake()->address(),
            'email' => fake()->unique()->email(),
            'phone' => fake()->numerify('#### ####'),
            'department_id' => $department->id, 
        ];
    }
}
