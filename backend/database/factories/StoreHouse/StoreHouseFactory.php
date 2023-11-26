<?php

namespace database\factories\StoreHouse;

use App\Models\StoreHouse\StoreHouse;
use Illuminate\Database\Eloquent\Factories\Factory;

class StoreHouseFactory extends Factory
{
    protected $model = StoreHouse::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'is_available' => $this->faker->boolean,
        ];
    }
}
