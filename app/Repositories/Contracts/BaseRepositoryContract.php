<?php

namespace App\Repositories\Contracts;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryContract
{
    public function paginate(): Paginator;

    public function findOrFail(int $modelId): Model;

    public function get(): Collection;

    public function create(array $payload): Model;

    public function update(int $modelId, array $payload): bool;

    public function deleteById(int $modelId): bool;
}
