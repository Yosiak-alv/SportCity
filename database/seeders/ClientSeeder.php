<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\System;
use App\Models\TrainingSession;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $systems = System::select('id')->get();
        $trainingSessions = TrainingSession::select('id')->get();

        Client::factory(10)->create()->each(function ($client) use ($systems,$trainingSessions){
            foreach($trainingSessions->random(rand(1,$trainingSessions->count())) as $trainingSession){
                $client->attendances_training_sessions()->attach($trainingSession,[
                    'attendance_date' => fake()->date()
                ]);
            }

            foreach($systems->random(rand(1,$systems->count())) as $system){
                $client->system_client()->attach($system,[
                    'condition' => fake()->paragraph(true)
                ]);
            }
        });

        Client::factory()->create([
            'dui' => '06357872-5',
            'name' => 'Josias Isaac',
            'lastname' => 'Ramirez',
            'phone' => '7808 5394',
            'email' => 'isaac@example.com',
            'gym_id' => 1,
        ]);
    }
}
