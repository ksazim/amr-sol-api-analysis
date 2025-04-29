<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->words(3, true);
        $cat = $this->faker->unique()->words(3, true);
        $stock = 10;

        return [
            'name' => ucfirst($name),
            'cat' => ucfirst($cat),
            'stock' => ucfirst($stock),
            'sku' => strtoupper(Str::slug($name)) . '-' . strtoupper(Str::random(4)),
            'description' => $this->faker->sentence(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
