<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use Carbon\Carbon;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $productBatchSize = 1000;
        $total = 40000;

        for ($i = 0; $i < $total; $i += $productBatchSize) {
            $nowObj = Carbon::now();
            $nowStr = $nowObj->format('Y-m-d H:i:s');

            // Generate product data
            $products = Product::factory()
                ->count($productBatchSize)
                ->make()
                ->map(function ($product) use ($nowStr) {
                    $array = $product->toArray();
                    $array['created_at'] = $nowStr;
                    $array['updated_at'] = $nowStr;
                    return $array;
                })
                ->toArray();

            // Insert products and get their IDs
            DB::table('products')->insert($products);
            $latestProductIds = DB::table('products')
                ->orderByDesc('id')
                ->limit($productBatchSize)
                ->pluck('id')
                ->reverse()
                ->values()
                ->toArray();

            $prices = [];

            foreach ($latestProductIds as $productId) {
                $prices[] = [
                    'product_id' => $productId,
                    'price' => fake()->randomFloat(2, 10, 500),
                    'starts_at' => $nowObj->copy()->subDays(rand(10, 30))->format('Y-m-d H:i:s'),
                    'ends_at' => null,
                    'is_current' => false,
                    'created_at' => $nowStr,
                    'updated_at' => $nowStr,
                ];

                $prices[] = [
                    'product_id' => $productId,
                    'price' => fake()->randomFloat(2, 10, 500),
                    'starts_at' => $nowObj->copy()->subDays(rand(1, 9))->format('Y-m-d H:i:s'),
                    'ends_at' => null,
                    'is_current' => true,
                    'created_at' => $nowStr,
                    'updated_at' => $nowStr,
                ];
            }

            // Insert prices in bulk
            DB::table('product_prices')->insert($prices);
        }
    }
}

