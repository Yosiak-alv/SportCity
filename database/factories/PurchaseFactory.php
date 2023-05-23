<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Purchase>
 */
class PurchaseFactory extends Factory
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

        $subTotal = fake()->randomFloat(2, 5, 500);
        $taxes = fake()->randomFloat(2, 1, 20);

        return [
            'client_id' => $client->id,
            'user_id' => $user->id,
            'item_count' => fake()->numberBetween(1, 20),
            'sub_total' => $subTotal,
            'taxes' => $taxes,
            'total' => $subTotal + $taxes,
            'finished' => true,
        ];
    }
}
