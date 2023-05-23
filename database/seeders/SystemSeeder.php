<?php

namespace Database\Seeders;

use App\Models\System;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $Systems = [
            'Sistema Nervioso',
            'Sistema Endocrino',
            'Sistema Circulatorio',
            'Sistema Digestivo',
            'Sistema Respiratorio',
            'Sistema Excretor',
            'Sistema Reproductor',
            'Sistema Muscular',
            'Sistema Esqueletico',
            'Sistema Inmunologico',
            'Sistema Linfatico',
            'Sistema Tegumentario'
        ];

        System::factory(count($Systems))->sequence(fn ($sequence)=> [
            'name' => $Systems[$sequence->index]
        ])->create();
    }
}
