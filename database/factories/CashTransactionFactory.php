<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CashTransaction>
 */
class CashTransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $client = Client::inRandomOrder()->limit(1)->first();

        return [
            'client_id' => $client->id,
            'mensaje' => fake()->paragraph(),
            'formaPago' => fake()->word(),
            'monto' => fake()->randomFloat(2,0,500),
        ];
    }
}
