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
            'Nervous System',        // Sistema Nervioso
            'Endocrine System',      // Sistema Endocrino
            'Circulatory System',    // Sistema Circulatorio
            'Digestive System',      // Sistema Digestivo
            'Respiratory System',    // Sistema Respiratorio
            'Excretory System',      // Sistema Excretor
            'Reproductive System',   // Sistema Reproductor
            'Muscular System',       // Sistema Muscular
            'Skeletal System',       // Sistema Esquelético
            'Immune System',         // Sistema Inmunológico
            'Lymphatic System',      // Sistema Linfático
            'Integumentary System'   // Sistema Tegumentario
        ];

        System::factory(count($Systems))->sequence(fn ($sequence)=> [
            'name' => $Systems[$sequence->index]
        ])->create();
    }
}
