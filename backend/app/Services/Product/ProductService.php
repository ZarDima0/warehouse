<?php

namespace App\Services\Product;

use App\DTO\Product\ProductDTO;
use App\Exceptions\LogicException;
use App\Models\StoreHouseProduct\StoreHouseProduct;
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
                $updateStoreProduct = $this->storeHouseProductRepository
                    ->updateStoreHouseProduct(
                        productId: $product->getId(),
                        storeHouseId: $productDTO->getStoreHouseId(),
                        result: [
                            'quantity' => $reserve ? $storeHouseProduct->getQuantity(
                                ) - 1 : $storeHouseProduct->getQuantity() + 1,
                            'reserved_quantity' => $reserve ? $storeHouseProduct->getReservedQuantity(
                                ) + 1 : $storeHouseProduct->getReservedQuantity() - 1
                        ]
                    );

                $product = $this->productRepository->updateProduct(
                    id: $product->getId(),
                    result: ['quantity' => $reserve ? $product->getQuantity() - 1 : $product->getQuantity() + 1]
                );

                if (!$product || !$updateStoreProduct) {
                    throw new LogicException('Ошибка при обновлении');
                }
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

    private function buildResult(StoreHouseProduct $storeHouseProduct, bool $reserve): array
    {
        if ($reserve) {
            return [
                'quantity' => $storeHouseProduct->getQuantity() - 1,
                'reserved_quantity' => $storeHouseProduct->getReservedQuantity() + 1
            ];
        }
        return [
            'quantity' => $storeHouseProduct->getQuantity() + 1,
            'reserved_quantity' => $storeHouseProduct->getReservedQuantity() - 1
        ];
    }
}
