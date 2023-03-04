<?php

namespace App\Providers;

use App\Repositories\CategoryRepository;
use App\Repositories\Contracts\CategoryRepositoryContract;
use App\Repositories\Contracts\ProductRepositoryContract;
use App\Repositories\Contracts\UserRepositoryContract;
use App\Repositories\ProductRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public array $singletons = [
        UserRepositoryContract::class     => UserRepository::class,
        CategoryRepositoryContract::class => CategoryRepository::class,
        ProductRepositoryContract::class  => ProductRepository::class,
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
