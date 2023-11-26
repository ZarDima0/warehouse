<?php

namespace App\Repositories;

use App\Models\StoreHouseProduct\StoreHouseProduct;
use App\Repositories\Interfaces\StoreHouseProductInterface;

class StoreHouseProductRepository implements StoreHouseProductInterface
{

    public function getStoreHouseProduct(int $productId, int $storeHouseId): StoreHouseProduct|null
    {
        return StoreHouseProduct::query()
            ->where('storehouse_id', '=', $storeHouseId)
            ->where('product_id', '=', $productId)
            ->first();
    }

    /**
     * @param int $productId
     * @param int $storeHouseId
     * @param array $result
     * @return bool
     */
    public function updateStoreHouseProduct(int $productId, int $storeHouseId, array $result): bool
    {
        return StoreHouseProduct::query()
            ->where('storehouse_id', '=', $storeHouseId)
            ->where('product_id', '=', $productId)
            ->update($result);
    }
}
