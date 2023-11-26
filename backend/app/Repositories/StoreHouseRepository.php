<?php

namespace App\Repositories;

use App\Models\StoreHouse\StoreHouse;
use App\Repositories\Interfaces\StoreHouseInterface;

class StoreHouseRepository implements StoreHouseInterface
{
    /**
     * @param int $id
     * @return bool
     */
    public function isAvailableStoreHouse(int $id): bool
    {
        $storeHouse = StoreHouse::query()->where('id', '=', $id)->first();
        if (is_null($storeHouse)) {
            return false;
        }
        return $storeHouse->isAvailable();
    }
}
