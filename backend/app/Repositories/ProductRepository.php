<?php

namespace App\Repositories;

use App\Models\Product\Product;
use App\Repositories\Interfaces\ProductInterface;

class ProductRepository implements ProductInterface
{

    /**
     * @param int $idProduct
     * @return Product|null
     */
    public function productFirst(int $idProduct): Product|null
    {
        return Product::query()->where('id', '=', $idProduct)->first();
    }

    /**
     * @param int $id
     * @param array $result
     * @return bool
     */
    public function updateProduct(int $id, array $result): bool
    {
        return Product::query()->where('id', '=', $id)->update($result);
    }
}
