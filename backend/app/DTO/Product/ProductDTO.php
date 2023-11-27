<?php

namespace App\DTO\Product;

class ProductDTO
{
    private array $productIds;

    /**
     * @var int
     */
    private int $storeHouseId;

    public function __construct(
        array $productIds,
        int $storeHouseId
    ) {
        $this->productIds = $productIds;
        $this->storeHouseId = $storeHouseId;
    }

    /**
     * @return int
     */
    public function getStoreHouseId(): int
    {
        return $this->storeHouseId;
    }

    public function getProductIds(): array
    {
        return $this->productIds;
    }
}
