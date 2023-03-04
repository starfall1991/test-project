<?php

use App\Dtos\CategoryDto;
use Illuminate\Support\Str;

it('should return a label from categoryDto', function () {
    $label       = Str::random();
    $categoryDto = new CategoryDto(label: $label);

    $this->assertEquals($categoryDto->getLabel(), $label);
});
