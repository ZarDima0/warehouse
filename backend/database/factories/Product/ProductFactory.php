<?php

namespace database\factories\Product;

use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'size' => $this->faker->numberBetween(1, 100),
            'unique_code' => $this->faker->unique()->randomNumber(6),
            'quantity' => 50,
        ];
    }
}
