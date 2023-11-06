<?php

namespace Database\Seeders;

use App\Models\CashTransaction;
use App\Models\Suscription;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SuscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suscriptions = Suscription::factory(20)->create();
    }
}
