<?php

namespace App\Repositories\Interfaces;

use App\Models\StoreHouseProduct\StoreHouseProduct;

interface StoreHouseProductInterface
{
    /**
     * Метод поиска товара на складе
     *
     * @param int $productId
     * @param int $storeHouseId
     * @return StoreHouseProduct|null
     */
    public function getStoreHouseProduct(int $productId, int $storeHouseId): StoreHouseProduct|null;

    /**
     * Метод для обновления
     *
     * @param int $productId
     * @param int $storeHouseId
     * @param array $result
     * @return bool
     */
    public function updateStoreHouseProduct(int $productId, int $storeHouseId, array $result): bool;

    /**
     * Метод получения общего количества товаров на складе
     *
     * @param int $storeHouseId
     * @return int
     */
    public function getCountProduct(int $storeHouseId): int;
}
