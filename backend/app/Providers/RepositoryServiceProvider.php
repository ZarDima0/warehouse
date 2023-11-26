<?php

namespace App\Providers;

use App\Repositories\Interfaces\ProductInterface;
use App\Repositories\Interfaces\StoreHouseInterface;
use App\Repositories\Interfaces\StoreHouseProductInterface;
use App\Repositories\ProductRepository;
use app\Repositories\StoreHouseProductRepository;
use app\Repositories\StoreHouseRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            ProductInterface::class,
            ProductRepository::class
        );
        $this->app->bind(
            StoreHouseInterface::class,
            StoreHouseRepository::class
        );
        $this->app->bind(
            StoreHouseProductInterface::class,
            StoreHouseProductRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
