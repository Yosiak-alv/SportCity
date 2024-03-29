<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleAndPermissionSeeder::class,
            
            DepartmentSeeder::class,
            GymSeeder::class,
            PlanSeeder::class,
            ProductSeeder::class,
            SystemSeeder::class,
            CoachSeeder::class,
            ExerciseSeeder::class,
            UserSeeder::class,
            TrainingSessionSeeder::class,
            ClientSeeder::class,
            SuscriptionSeeder::class,
            PurchaseSeeder::class,
            PurchaseItemsSeeder::class,

          
        ]);
    }
}
