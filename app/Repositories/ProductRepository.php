<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryContract;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository extends BaseRepository implements ProductRepositoryContract
{
    public function __construct()
    {
        $this->model = app(Product::class);
    }

    public function getCategories(int $productId): Collection
    {
        return $this->model->newQuery()
            ->findOrFail($productId)
            ->categories()
            ->get();
    }

    public function syncCategories(int $productId, array $categoryIds): void
    {
        $this->model->newQuery()
            ->findOrFail($productId)
            ->categories()
            ->sync($categoryIds);
    }
}
