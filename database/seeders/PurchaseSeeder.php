<?php

namespace Database\Seeders;

use App\Models\CashTransaction;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItems;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Auth\User;

class PurchaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       /*  $products = Product::select('id')->get();

        $purchases = Purchase::factory(25)->create()->each(function ($purchase) use ($products){
            foreach($products->random(rand(1,$products->count())) as $product){
                $purchase->purchase_products()->attach($product,[
                    'attendance_date' => fake()->date()
                ]);
            }
        }); */

        $purchases = Purchase::factory(25)->create()->each(function ($purchase) {
            $sub_total = 0;
            $item_count = 0;

            $purchase_items = PurchaseItems::factory(rand(1, 10))->create();
            foreach ($purchase_items as $item) {
                $item->purchase_id = $purchase->id;
                $sub_total += $item->item_total;
                $item_count += $item->quantity;
                $item->save();
            }

            $purchase->user_id = User::inRandomOrder()->limit(1)->first()->id;
            $purchase->item_count = $item_count;
            $purchase->sub_total = $sub_total;
            $purchase->taxes = round($sub_total * 0.10, 2);
            $purchase->total =  $purchase->taxes + $sub_total;
            $purchase->save();
        });

        CashTransaction::factory(count($purchases))->sequence(fn($sqn)=>[
            'client_id' => $purchases[$sqn->index]->client_id,
            'purchase_id' => $purchases[$sqn->index]->id,
            'monto' => $purchases[$sqn->index]->total,
        ])->create();
    }
}
