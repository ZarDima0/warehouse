<?php

namespace database\factories\StoreHouseProduct;

use App\Models\Product\Product;
use App\Models\StoreHouse\StoreHouse;
use App\Models\StoreHouseProduct\StoreHouseProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

class StoreHouseProductFactory extends Factory
{
    protected $model = StorehouseProduct::class;

    public function definition(): array
    {
        return [
            'storehouse_id' => function () {
                return StoreHouse::factory()->create()->id;
            },
            'product_id' => function () {
                return Product::factory()->create()->id;
            },
            'quantity' => 25,
            'reserved_quantity' => 0,
        ];
    }
}
