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
            'productСodes' => 'required|array',
            'productСodes.*' => 'required|integer|distinct',
        ];
    }

    /**
     * @return ProductDTO
     */
    public function getProductsCodeDTO(): ProductDTO
    {
        return (new ProductDTO($this->input('productСodes.*'), $this->input('storeHouseId')));
    }
}
