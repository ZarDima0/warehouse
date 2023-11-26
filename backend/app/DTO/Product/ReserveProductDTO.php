<?php

namespace App\DTO\Product;

class ReserveProductDTO
{
    private array $productCodes;

    /**
     * @var int
     */
    private int $storeHouseId;

    public function __construct(
        array $productCodes,
        int   $storeHouseId
    )
    {
        $this->productCodes = $productCodes;
        $this->storeHouseId = $storeHouseId;
    }

    /**
     * @return int
     */
    public function getStoreHouseId(): int
    {
        return $this->storeHouseId;
    }

    public function getProductCodes(): array
    {
        return $this->productCodes;
    }
}
