<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface ProductRepositoryContract extends BaseRepositoryContract
{
    public function getCategories(int $productId): Collection;

    public function syncCategories(int $productId, array $categoryIds): void;
}
