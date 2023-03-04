<?php

namespace App\Services;

use App\Repositories\Contracts\BaseRepositoryContract;
use App\Services\Contracts\BaseCrudServiceContract;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class BaseCrudService implements BaseCrudServiceContract
{
    protected BaseRepositoryContract $repository;

    public function paginate(): Paginator
    {
        return $this->repository->paginate();
    }

    public function show(int $modelId): Model
    {
        return $this->repository->findOrFail($modelId);
    }

    public function get(): Collection
    {
        return $this->repository->get();
    }

    public function delete(int $modelId): bool
    {
        return $this->repository->deleteById($modelId);
    }
}
