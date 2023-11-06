<?php

namespace Database\Factories;

use App\Models\Gym;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;


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
        $starts_at = Carbon::createFromTimeStamp(fake()->dateTimeBetween('-1 years', '+1 month')->getTimestamp());
        return [
            'name' =>fake()->unique()->word(),
            'description' => fake()->paragraph(),
            'duration' => fake()->randomFloat(2,0,60),
            'gym_id' => $gym->id,
            'user_id' => $user->id,
            'starts_at' => $starts_at->timezone('America/El_Salvador')->toDateTimeString(),
            'finish_at' => $starts_at->timezone('America/El_Salvador')->addHours( fake()->numberBetween( 1, 8 ) )
        ];
    }
}
