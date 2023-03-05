<?php

namespace App\Services;

use App\Dtos\ProductDto;
use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryContract;
use App\Services\Contracts\ProductServiceContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ProductService extends BaseCrudService implements ProductServiceContract
{
    public function __construct()
    {
        $this->repository = app(ProductRepositoryContract::class);
    }

    public function create(ProductDto $productDto): Product|Model|array
    {
        return $this->repository->create([
            'label' => $productDto->getLabel(),
        ]);
    }

    public function update(int $modelId, ProductDto $productDto): bool
    {
        return $this->repository->update(
            modelId: $modelId,
            payload: [
                'label' => $productDto->getLabel(),
            ],
        );
    }

    public function getCategories(int $productId): Collection
    {
        return $this->repository->getCategories($productId);
    }

    public function syncCategories(int $productId, array $categoryIds): void
    {
        $this->repository->syncCategories($productId, $categoryIds);
    }
}
