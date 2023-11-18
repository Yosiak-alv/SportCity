<?php

namespace Database\Factories;

use App\Models\Gym;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
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
            'dui' => fake()->unique()->numerify('########-#'),
            'name' => fake()->name(),
            'lastname' => fake()->lastName(),
            'genre' => fake()->randomElement(['M','H']),
            'phone' =>fake()->numerify('########'),
            'address' => fake()->address(),
            'birth_date' => fake()->date(),
            'height' =>fake()->randomFloat(2,0,5),
            'weight' => fake()->randomFloat(2,0,600),
            'gym_id' => $gym->id,
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }
}
