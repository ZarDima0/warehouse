<?php

namespace App\Repositories\Interfaces;

use App\Models\Product\Product;

interface ProductInterface
{
    /**
     * Получить Product по unique_code
     *
     * @param int $uniqueCode
     * @return Product|null
     */
    public function uniqueCodeFirst(int $uniqueCode): Product|null;

    /**
     * Метод для обновления сущности Product
     *
     * @param int $id
     * @param array $result
     * @return bool
     */
    public function updateProduct(int $id, array $result): bool;

}
