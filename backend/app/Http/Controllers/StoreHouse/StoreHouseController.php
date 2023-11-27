<?php

namespace App\Http\Controllers\StoreHouse;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHouse\CountProductsRequest;
use App\Http\Resources\StoreHouse\CountProductResource;
use App\Services\Storehouse\StoreHouseService;

class StoreHouseController extends Controller
{
    /**
     * Метод возвращает количество продуктов на складе
     *
     * @param CountProductsRequest $request
     * @param StoreHouseService $service
     * @return CountProductResource
     * @throws \Exception
     */
    public function getCountProduct(CountProductsRequest $request, StoreHouseService $service): CountProductResource
    {
        return new CountProductResource($service->countProducts($request->getStoreHouseId()));
    }
}
