<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Contracts\CategoryRepositoryContract;

class ProductRepository extends BaseRepository implements CategoryRepositoryContract
{
    public function __construct()
    {
        $this->model = app(Product::class);
    }
}
