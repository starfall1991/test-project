<?php

namespace App\Services\Contracts;

use App\Dtos\CategoryDto;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

interface CategoryServiceContract extends BaseCrudServiceContract
{
    public function create(CategoryDto $categoryDto): Category|Model|array;

    public function update(int $modelId, CategoryDto $categoryDto): bool;
}
