<?php

namespace App\Http\Resources\StoreHouse;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CountProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'quantity' => $this->resource
        ];
    }
}
