<?php

namespace App\Services;

use App\Dtos\CategoryDto;
use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryContract;
use App\Services\Contracts\CategoryServiceContract;
use Illuminate\Database\Eloquent\Model;

class CategoryService extends BaseCrudService implements CategoryServiceContract
{
    public function __construct()
    {
        $this->repository = app(CategoryRepositoryContract::class);
    }

    public function create(CategoryDto $categoryDto): Category|Model|array
    {
        return $this->repository->create([
            'label' => $categoryDto->getLabel(),
        ]);
    }

    public function update(int $modelId, CategoryDto $categoryDto): bool
    {
        return $this->repository->update(
            modelId: $modelId,
            payload: [
                'label' => $categoryDto->getLabel(),
            ],
        );
    }
}
