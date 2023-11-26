<?php

namespace App\Models\StoreHouse;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\StoreHouse\StoreHouse

 * @property string $name Название
 * @property string $is_available Признак доступности склада
 * @method static \Illuminate\Database\Eloquent\Builder|StoreHouse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StoreHouse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StoreHouse query()
 * @mixin \Eloquent
 */
class StoreHouse extends Model
{
    use HasFactory;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getIsAvailable(): string
    {
        return $this->is_available;
    }

    /**
     * @param string $is_available
     */
    public function setIsAvailable(string $is_available): void
    {
        $this->is_available = $is_available;
    }
}
