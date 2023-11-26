<?php

namespace App\Services\Product;

use App\DTO\Product\ReserveProductDTO;
use App\Models\Product\Product;
use App\Repositories\Interfaces\ProductInterface;
use App\Repositories\Interfaces\StoreHouseInterface;
use App\Repositories\Interfaces\StoreHouseProductInterface;
use Exception;
use Illuminate\Support\Facades\DB;

class ProductService
{
    private ProductInterface $productRepository;
    private StoreHouseInterface $storeHouseRepository;
    private StoreHouseProductInterface $storeHouseProductRepository;

    public function __construct(
        ProductInterface           $productRepository,
        StoreHouseInterface        $storeHouseRepository,
        StoreHouseProductInterface $storeHouseProductRepository,
    )
    {
        $this->productRepository = $productRepository;
        $this->storeHouseRepository = $storeHouseRepository;
        $this->storeHouseProductRepository = $storeHouseProductRepository;
    }

    /**
     * @param ReserveProductDTO $productDTO
     * @return bool
     */
    public function reserve(ReserveProductDTO $productDTO): bool
    {
        try {
            if ($this->storeHouseRepository->isAvailableStoreHouse($productDTO->getStoreHouseId())) {
                throw new Exception('Склад недоступен');
            }

            foreach ($productDTO->getProductCodes() as $code) {
                $product = $this->productRepository->uniqueCodeFirst($code);
                if (is_null($product)) {
                    throw new Exception('Позиция не найдена');
                }
                $storeHouseProduct = $this->storeHouseProductRepository
                    ->getStoreHouseProduct($product->getId(), $productDTO->getStoreHouseId());
                if (
                    is_null($storeHouseProduct)
                    || $storeHouseProduct->getQuantity() == 0
                    || $product->getQuantity() == 0
                ) {
                    throw new Exception('Позиция отсутствует на складе');
                }

                $this->storeHouseProductRepository
                    ->updateStoreHouseProduct(
                        productId: $productDTO->getStoreHouseId(),
                        storeHouseId: $product->getId(),
                        result: [
                            'quantity' => $storeHouseProduct->getQuantity() - 1,
                            'reserved_quantity' => $storeHouseProduct->getReservedQuantity() + 1,
                        ]
                    );

                $this->productRepository->updateProduct(
                    id: $product->getId(),
                    result: ['quantity' => $product->getQuantity() - 1]
                );
            }
            DB::commit();
            return true;
        } catch (Exception $exception) {
            DB::rollBack();
            return false;
        }
    }
}
