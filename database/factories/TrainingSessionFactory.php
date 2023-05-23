<?php

namespace Database\Factories;

use App\Models\Gym;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TrainingSession>
 */
class TrainingSessionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::inRandomOrder()->limit(1)->first();
        $gym = Gym::inRandomOrder()->limit(1)->first();
        return [
            'name' =>fake()->word(),
            'description' => fake()->paragraph(),
            'duration' => fake()->randomFloat(2,0,60),
            'gym_id' => $gym->id,
            'user_id' => $user->id,
            'starts_at' => fake()->date(),
            'finish_at' => fake()->date(),
            
        ];
    }
}
