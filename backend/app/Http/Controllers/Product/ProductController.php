<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ReserveProductsRequest;
use App\Services\Product\ProductService;
use Illuminate\Http\JsonResponse;


class ProductController extends Controller
{
    /**
     * @param ReserveProductsRequest $request
     * @param ProductService $service
     * @return JsonResponse
     */
    public function reserveProducts(ReserveProductsRequest $request, ProductService $service): JsonResponse
    {
        $reserve = $service->reserve($request->getProductsCodeDTO());
        if ($reserve) {
            return response()->json(['message' => "Товары забронированы"]);
        }
        return response()->json(['error' => "Ошибка при бронировании товаров"]);
    }
}
