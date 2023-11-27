<?php

namespace App\Http\Requests\Product;

use App\DTO\Product\ProductDTO;
use Illuminate\Foundation\Http\FormRequest;

class ReleaseProductsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'storeHouseId' => 'required|integer',
            'productIds' => 'required|array',
            'productIds.*' => 'required|integer|distinct',
        ];
    }

    /**
     * @return ProductDTO
     */
    public function getProductsCodeDTO(): ProductDTO
    {
        return (new ProductDTO($this->input('productIds.*'), $this->input('storeHouseId')));
    }
}
