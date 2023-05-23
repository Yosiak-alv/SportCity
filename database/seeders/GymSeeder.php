<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Gym;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GymSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $department = Department::where('name','Sonsonate')->limit(1)->first();
        Gym::factory(1)->create([
            'name' => 'SportCity',
            'address' => '10 Avenida Norte y 5 Cale Oriente, Barrio El Angel',
            'department_id' => $department->id, 
        ]);
    }
}
