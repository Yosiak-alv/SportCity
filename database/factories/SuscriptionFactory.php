<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Suscription>
 */
class SuscriptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $client = Client::inRandomOrder()->limit(1)->first();
        $user = User::inRandomOrder()->limit(1)->first();
        $plan  = Plan::inRandomOrder()->limit(1)->first();
        return [
            'client_id' => $client->id,
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'ends_at' => fake()->date(),
        ];
    }
}
