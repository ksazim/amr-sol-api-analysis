<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductPrice;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::factory()
            ->count(20)
            ->create()
            ->each(function ($product) {
                $product->prices()->createMany([
                    ProductPrice::factory()->make(['is_current' => false])->toArray(),
                    ProductPrice::factory()->make(['is_current' => true])->toArray(),
                ]);
            });
    }
}
