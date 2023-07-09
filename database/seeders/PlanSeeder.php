<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            'Membresia Mensual',
            'Pesas',
            'Entrenamiento del Dia'
        ];
        $prices = [
            20.00,
            12.00,
            2.00
        ];

        Plan::factory(count($plans))->sequence(fn ($sequence)=> [
            'name' => $plans[$sequence->index],
            'price' => $prices[$sequence->index]
        ])->create();
    }
}
