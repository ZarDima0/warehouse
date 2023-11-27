<?php

namespace App\Services\Product;

use App\DTO\Product\ProductDTO;
use App\Exceptions\LogicException;
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
        ProductInterface $productRepository,
        StoreHouseInterface $storeHouseRepository,
        StoreHouseProductInterface $storeHouseProductRepository,
    ) {
        $this->productRepository = $productRepository;
        $this->storeHouseRepository = $storeHouseRepository;
        $this->storeHouseProductRepository = $storeHouseProductRepository;
    }

    /**
     * @param ProductDTO $productDTO
     * @return bool
     * @throws Exception
     */
    public function reserve(ProductDTO $productDTO): bool
    {
        return $this->updateProductQuantity($productDTO, true);
    }

    /**
     * @throws Exception
     */
    private function updateProductQuantity(ProductDTO $productDTO, bool $reserve): bool
    {
        DB::beginTransaction();
        try {
            if (!$this->storeHouseRepository->isAvailableStoreHouse($productDTO->getStoreHouseId())) {
                throw new LogicException('Склад недоступен');
            }

            foreach ($productDTO->getProductIds() as $productId) {
                $product = $this->productRepository->productFirst($productId);
                if (is_null($product)) {
                    throw new LogicException('Позиция не найдена');
                }
                $storeHouseProduct = $this->storeHouseProductRepository
                    ->getStoreHouseProduct($product->getId(), $productDTO->getStoreHouseId());
                if (
                    is_null($storeHouseProduct)
                    || $storeHouseProduct->getQuantity() == 0
                    || $product->getQuantity() == 0
                ) {
                    throw new LogicException('Позиция отсутствует на складе');
                }

                if ($storeHouseProduct->getReservedQuantity() == 0 && !$reserve) {
                    throw new LogicException('Нет забронированных позиций');
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
            throw $exception;
        }
    }

    /**
     * @param ProductDTO $productDTO
     * @return bool
     * @throws Exception
     */
    public function release(ProductDTO $productDTO): bool
    {
        return $this->updateProductQuantity($productDTO, false);
    }
}
