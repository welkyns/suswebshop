<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\CategoryContract;
use App\Repositorios\CategoryRepository;
use App\Contracts\AttributeContract;
use App\Repositorios\AttributeRepository;
use App\Contracts\BrandContract;
use App\Repositorios\BrandRepository;
use App\Contracts\ProductContract;
use App\Repositorios\ProductRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    protected $repositories = [
        CategoryContract::class => CategoryRepository::class,
        AttributeContract::class => AttributeRepository::class,
        BrandContract::class => BrandRepository::class,
        ProductContract::class => ProductRepository::class
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        foreach ($this->repositories as $interface => $implementation)
        {
            $this->app->bind($interface, $implementation);
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
