<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            'Ahuachapan',
            'Sonsonate',
            'Santa Ana',
            'La Libertad',
            'Chalatenango',
            'San Salvador',
            'Cuscatlan',
            'La Paz',
            'San Vicente',
            'Cabañas',
            'Usulutan',
            'San Miguel',
            'Morazan',
            'La Union'
        ];

        Department::factory(count($departments))->sequence( fn ($sqn) => ['name' => $departments[$sqn->index]])->create();

        
    }
}
