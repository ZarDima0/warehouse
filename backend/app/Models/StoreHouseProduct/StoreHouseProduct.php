<?php

namespace App\Models\StoreHouseProduct;

use App\Models\Product\Product;
use App\Models\StoreHouse\StoreHouse;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * App\Models\StoreHouseProduct\StoreHouseProduct
 *
 * @property integer $id
 * @property integer $storehouse_id ID склада
 * @property integer $product_id ID продукта
 * @property integer $quantity Количество товара на складе
 * @property integer $reserved_quantity Количество зарезервированного товара
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read StoreHouse $storeHouse
 * @property-read Product $product
 * @method static Builder|StoreHouseProduct newModelQuery()
 * @method static Builder|StoreHouseProduct newQuery()
 * @method static Builder|StoreHouseProduct query()
 * @mixin Eloquent
 */
class StoreHouseProduct extends Model
{
    use HasFactory;

    /**
     * @return HasOne
     */
    public function storeHouse(): HasOne
    {
        return $this->hasOne(StoreHouse::class, 'id', 'storehouse_id');
    }

    /**
     * @return HasOne
     */
    public function product(): HasOne
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getStorehouseId(): int
    {
        return $this->storehouse_id;
    }

    /**
     * @param int $storehouse_id
     */
    public function setStorehouseId(int $storehouse_id): void
    {
        $this->storehouse_id = $storehouse_id;
    }

    /**
     * @return int
     */
    public function getProductId(): int
    {
        return $this->product_id;
    }

    /**
     * @param int $product_id
     */
    public function setProductId(int $product_id): void
    {
        $this->product_id = $product_id;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * @return int
     */
    public function getReservedQuantity(): int
    {
        return $this->reserved_quantity;
    }

    /**
     * @param int $reserved_quantity
     */
    public function setReservedQuantity(int $reserved_quantity): void
    {
        $this->reserved_quantity = $reserved_quantity;
    }
}
