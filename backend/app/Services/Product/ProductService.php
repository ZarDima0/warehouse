<?php

namespace App\Services\Product;

use App\DTO\Product\ProductDTO;
use App\Repositories\Interfaces\ProductInterface;
use App\Repositories\Interfaces\StoreHouseInterface;
use App\Repositories\Interfaces\StoreHouseProductInterface;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductService
{
    const LOG_CHANNEL_RESERVE = 'reserve';
    const LOG_CHANNEL_RELEASE = 'release';


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
     * @param ProductDTO $productDTO
     * @return bool
     */
    public function reserve(ProductDTO $productDTO): bool
    {
        return $this->updateProductQuantity($productDTO, true);
    }

    /**
     * @param ProductDTO $productDTO
     * @return bool
     */
    public function release(ProductDTO $productDTO): bool
    {
        return $this->updateProductQuantity($productDTO, false);
    }

    private function updateProductQuantity(ProductDTO $productDTO, bool $reserve): bool
    {
        try {
            DB::beginTransaction();
            if (!$this->storeHouseRepository->isAvailableStoreHouse($productDTO->getStoreHouseId())) {
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
                            'quantity' => $storeHouseProduct->getQuantity() - ($reserve ? 1 : -1),
                            'reserved_quantity' => $storeHouseProduct->getReservedQuantity() + ($reserve ? 1 : -1),
                        ]
                    );

                $this->productRepository->updateProduct(
                    id: $product->getId(),
                    result: ['quantity' => $product->getQuantity() - ($reserve ? 1 : -1)]
                );
            }
            DB::commit();
            return true;
        } catch (Exception $exception) {
            Log::channel($reserve ? self::LOG_CHANNEL_RESERVE : self::LOG_CHANNEL_RELEASE)
                ->error('Message:' . $exception->getMessage());
            Log::channel($reserve ? self::LOG_CHANNEL_RESERVE : self::LOG_CHANNEL_RELEASE)
                ->error('Trace:' . $exception->getTraceAsString());
            DB::rollBack();
            return false;
        }
    }
}
