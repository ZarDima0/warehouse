<?php

namespace App\Http\Requests\StoreHouse;

use App\DTO\Product\ProductDTO;
use Illuminate\Foundation\Http\FormRequest;

class CountProductsRequest extends FormRequest
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
        ];
    }

    /**
     * @return int
     */
    public function getStoreHouseId(): int
    {
        return $this->input('storeHouseId');
    }
}
