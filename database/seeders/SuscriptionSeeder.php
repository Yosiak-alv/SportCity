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

        CashTransaction::factory(count($suscriptions))->sequence(fn($sqn)=>[
            'client_id' => $suscriptions[$sqn->index]->client_id,
            'suscription_id' => $suscriptions[$sqn->index]->id
        ])->create();
    }
}
