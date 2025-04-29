<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ProductPrice;
use App\Models\Product;

class ProductPriceFactory extends Factory
{
    protected $model = ProductPrice::class;

    public function definition(): array
    {

        return [
            'product_id' => Product::factory(),
            'price' => $this->faker->randomFloat(2, 5, 500),
            'starts_at' => now()->subDays(rand(1, 30)),
            'ends_at' => null, // Or add end date logic
            'is_current' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
