<?php

use App\Dtos\ProductDto;
use Illuminate\Support\Str;

it('should return a label from productDto', function () {
    $label      = Str::random();
    $productDto = new ProductDto(label: $label);

    $this->assertEquals($productDto->getLabel(), $label);
});
