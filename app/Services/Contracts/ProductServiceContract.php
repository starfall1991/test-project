<?php

namespace App\Services\Contracts;

use App\Dtos\ProductDto;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface ProductServiceContract extends BaseCrudServiceContract
{
    public function create(ProductDto $productDto): Product|Model|array;

    public function update(int $modelId, ProductDto $productDto): bool;

    public function getCategories(int $productId): Collection;

    public function syncCategories(int $productId, array $categoryIds): void;
}
