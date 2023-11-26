<?php

namespace App\Providers;

use App\Repositories\Interfaces\ProductInterface;
use App\Repositories\Interfaces\StoryHouseInterface;
use App\Repositories\Interfaces\StoryHouseProductInterface;
use App\Repositories\ProductRepository;
use app\Repositories\StoryHouseProductRepository;
use app\Repositories\StoryHouseRepository;
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
            StoryHouseInterface::class,
            StoryHouseRepository::class
        );
        $this->app->bind(
            StoryHouseProductInterface::class,
            StoryHouseProductRepository::class
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
