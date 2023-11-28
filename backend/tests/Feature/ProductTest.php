<?php

namespace Tests\Feature;

use App\Models\StoreHouse\StoreHouse;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_reserve(): void
    {
        $activeStoreHouse = StoreHouse::query()->where('is_available', '=', 1)->first();

        $response = $this->post(
            route('product.reverse', [
                "storeHouseId" => $activeStoreHouse->id,
                "productIds" => [1, 4]
            ])
        );

        $response->assertStatus(200);
    }

    public function test_release()
    {
        $activeStoreHouse = StoreHouse::query()->where('is_available', '=', 1)->first();

        $response = $this->post(
            route('product.release', [
                "storeHouseId" => $activeStoreHouse->id,
                "productIds" => [1, 4]
            ])
        );

        $response->assertStatus(200);
    }
}
