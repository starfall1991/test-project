<?php

namespace App\Dtos;

class CategoryProductDto
{
    public function __construct(
        protected int $productId,
        protected int $categoryId,
    ) {
    }

    /**
     * @return int
     */
    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    /**
     * @return int
     */
    public function getProductId(): int
    {
        return $this->productId;
    }
}
