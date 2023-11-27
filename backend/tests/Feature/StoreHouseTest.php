<?php

namespace Tests\Feature;

use App\Models\StoreHouse\StoreHouse;
use App\Models\StoreHouseProduct\StoreHouseProduct;
use Tests\TestCase;

class StoreHouseTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_count_product(): void
    {
        $activeStoreHouse = StoreHouse::query()->where('is_available', '=', 1)->first();
        $productsCount = StoreHouseProduct::query()
            ->where('storehouse_id', '=', $activeStoreHouse->id)
            ->sum('quantity');
        $response = $this->post(route('store-house.count-product'), ['storeHouseId' => $activeStoreHouse->id]);

        $response->assertStatus(200);
        $response->assertExactJson(['quantity' => $productsCount]);
    }
}
