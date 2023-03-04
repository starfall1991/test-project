<?php

namespace App\Dtos;

class ProductDto
{
    public function __construct(
        protected string $label,
    ) {
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }
}
