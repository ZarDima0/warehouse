<?php

namespace App\Services\Storehouse;

use App\Exceptions\LogicException;
use App\Repositories\Interfaces\StoreHouseInterface;
use App\Repositories\Interfaces\StoreHouseProductInterface;
use Exception;

class StoreHouseService
{
    private StoreHouseInterface $storeHouseRepository;
    private StoreHouseProductInterface $storeHouseProductRepository;


    public function __construct(
        StoreHouseInterface $storeHouseRepository,
        StoreHouseProductInterface $storeHouseProductRepository,
    ) {
        $this->storeHouseRepository = $storeHouseRepository;
        $this->storeHouseProductRepository = $storeHouseProductRepository;
    }

    /**
     * @throws Exception
     */
    public function countProducts(int $StoreHouseId): int
    {
        if (!$this->storeHouseRepository->isAvailableStoreHouse($StoreHouseId)) {
            throw new LogicException('Склад недоступен');
        };
        $count = $this->storeHouseProductRepository->getCountProduct($StoreHouseId);
        if ($count == 0) {
            throw new LogicException('Товаров на складе нет');
        }
        return $count;
    }
}
