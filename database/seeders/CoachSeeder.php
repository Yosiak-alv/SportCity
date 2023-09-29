<?php

namespace Database\Seeders;

use App\Models\Coach;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CoachSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Coach::factory(10)->create();

        Coach::factory()->create([
            'dui' => '07357872-5',
            'name' => 'Jose Isaac',
            'lastname' => 'Ramirez',
            'phone' => '7808 5394',
            'email' => 'jose@example.com',
            'gym_id' => 1,
        ]);
    }
}
