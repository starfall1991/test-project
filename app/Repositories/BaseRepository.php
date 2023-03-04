<?php

namespace App\Repositories;

use App\Repositories\Contracts\BaseRepositoryContract;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseRepositoryContract
{
    protected Model $model;

    public function paginate(): Paginator
    {
        return $this->model->newQuery()
            ->paginate();
    }

    public function findOrFail(int $modelId): Model
    {
        return $this->model->newQuery()
            ->findOrfail($modelId);
    }

    public function get(): Collection
    {
        return $this->model->newQuery()
            ->get();
    }

    public function create(array $payload): Model
    {
        return $this->model->newQuery()
            ->create($payload);
    }

    public function update(int $modelId, array $payload): bool
    {
        return $this->model->newQuery()
            ->where(column: 'id', operator: '=', value: $modelId)
            ->update($payload);
    }

    public function deleteById(int $modelId): bool
    {
        return $this->model->newQuery()
            ->where(column: 'id', operator: '=', value: $modelId)
            ->delete();
    }
}
