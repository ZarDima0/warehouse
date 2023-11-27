<?php

namespace App\Repositories\Interfaces;

use App\Models\Product\Product;

interface ProductInterface
{
    /**
     * Получить Product по unique_code
     *
     * @param int $idProduct
     * @return Product|null
     */
    public function productFirst(int $idProduct): Product|null;

    /**
     * Метод для обновления сущности Product
     *
     * @param int $id
     * @param array $result
     * @return bool
     */
    public function updateProduct(int $id, array $result): bool;

}
