<?php

namespace App\Providers;

use App\Services\CategoryService;
use App\Services\Contracts\CategoryServiceContract;
use App\Services\Contracts\ProductServiceContract;
use App\Services\Contracts\UserServiceContract;
use App\Services\ProductService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class FacilityServiceProvider extends ServiceProvider
{
    public array $singletons = [
        UserServiceContract::class     => UserService::class,
        CategoryServiceContract::class => CategoryService::class,
        ProductServiceContract::class  => ProductService::class,
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
