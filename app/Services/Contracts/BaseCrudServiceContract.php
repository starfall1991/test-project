<?php

namespace App\Services\Contracts;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface BaseCrudServiceContract
{

    public function paginate(): Paginator;

    public function show(int $modelId): Model;

    public function get(): Collection;

    public function delete(int $modelId): bool;
}
