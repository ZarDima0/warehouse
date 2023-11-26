<?php
namespace App\Repositories\Interfaces;

interface StoreHouseInterface
{
    /**
     * @param int $id
     * @return bool
     */
    public function isAvailableStoreHouse(int $id): bool;
}
