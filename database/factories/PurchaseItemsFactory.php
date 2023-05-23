<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PurchaseItems>
 */
class PurchaseItemsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $quantity = fake()->randomDigitNotZero();
        $product = Product::inRandomOrder()->limit(1)->first();
        return [
            'purchase_id' => Purchase::inRandomOrder()->limit(1)->first()->id,
            'product_id' => $product->id,
            'quantity' => $quantity,
            'unit_price' => $product->unit_price,
            'item_total' => $quantity * $product->unit_price,
        ];
    }
}
