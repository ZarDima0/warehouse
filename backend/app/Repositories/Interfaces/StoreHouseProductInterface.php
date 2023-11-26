<?php

namespace App\Repositories\Interfaces;

use App\Models\StoreHouseProduct\StoreHouseProduct;

interface StoreHouseProductInterface
{
    /**
     * @param int $productId
     * @param int $storeHouseId
     * @return StoreHouseProduct|null
     */
    public function getStoreHouseProduct(int $productId, int $storeHouseId): StoreHouseProduct|null;

    public function updateStoreHouseProduct(int $productId, int $storeHouseId, array $result): bool;
}
