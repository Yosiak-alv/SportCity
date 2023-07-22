<?php

namespace Database\Seeders;

use App\Models\Coach;
use App\Models\Exercise;
use App\Models\TrainingSession;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TrainingSessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $exercises = Exercise::select('id')->get();
        $coaches = Coach::select('id')->get();

        TrainingSession::factory(15)->create()->each(function ($trainingSession) use ($exercises,$coaches){
            foreach($exercises->random(rand(1,$exercises->count())) as $exercise){
                $trainingSession->training_sessions_exercises()->attach($exercise,[
                    'repetitions' => random_int(0,50),
                    'instructions' => fake()->paragraph()
                ]); 
            }

            foreach($coaches->random(rand(1,$coaches->count())) as $coach){
                $trainingSession->training_sessions_coaches()->attach($coach);
            }
        });
    }
}
