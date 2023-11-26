<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Product\Product;
use App\Models\StoreHouse\StoreHouse;
use App\Models\StoreHouseProduct\StoreHouseProduct;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $storeHouses = StoreHouse::factory()->count(2)->create();

        $products = Product::factory()->count(50)->create();

        foreach ($storeHouses as $storeHouse) {
            foreach ($products->take(25) as $product) {
                StoreHouseProduct::factory()->create([
                    'storehouse_id' => $storeHouse->id,
                    'product_id' => $product->id,
                ]);
            }
        }
    }
}
