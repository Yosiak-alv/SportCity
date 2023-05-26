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
            CardTransactionSeeder::class,
            CashTransactionSeeder::class,
            PurchaseSeeder::class,
            PurchaseItemsSeeder::class,

            RoleAndPermissionSeeder::class
        ]);
    }
}
