<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\PlanDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = collect([
            [
                'name' => 'Full-Access',
                'description' => 'The best option to start your new life.',
                'duration' => 'Month',
                'price' => 20.00,
                'details' => [
                    'Access to all facilities.',
                    'Access at any time (within hours).', 
                    'Daily Routine.', 
                    'Group Classes.', 
                    'Focused Training.',
                ]
            ],
            [
                'name' => 'Daily',
                'description' => 'Excellent starting point created for those who do not have much time.',
                'duration' => 'Day',
                'price' => 3.00,
                'details' => [
                    'Access to all facilities.',
                    'Access at any time (within hours).', 
                ]
            ]
        ]);

        
        $plans->each(function ($planData) {
            $plan = Plan::factory()->create([
                'name' => $planData['name'],
                'description' => $planData['description'],
                'duration' => $planData['duration'],
                'price' => $planData['price'],
            ]);

            $details = collect($planData['details'])->map(function ($detail) {
                return new PlanDetail(['detail' => $detail]);
            });

            $plan->details()->saveMany($details);
        });
    }
}
