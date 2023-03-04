<?php

use App\Dtos\ProductDto;
use App\Models\Category;
use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryContract;
use App\Services\Contracts\ProductServiceContract;

beforeEach(function () {
    $this->mockProductRepository = Mockery::mock(ProductRepositoryContract::class);
    $this->app->instance(ProductRepositoryContract::class, $this->mockProductRepository);
});

it('should return a list of products', function () {
    $products = Product::factory()->count(10)->create();

    $this->mockProductRepository->shouldReceive('get')->once()->andReturn($products);

    $productService = app(ProductServiceContract::class);

    $result = $productService->get();

    $this->assertInstanceOf(expected: Product::class, actual: $result->random()->first());
    $this->assertEquals(expected: $products->toArray(), actual: $result->toArray());
});

it('should create a new product', function () {
    $label      = fake()->name;
    $productDto = new ProductDto(label: $label);
    $this->mockProductRepository
        ->shouldReceive('create')
        ->once()
        ->with(['label' => $label])
        ->andReturn(new Product());

    $productService = app(ProductServiceContract::class);

    $result = $productService->create($productDto);

    $this->assertInstanceOf(expected: Product::class, actual: $result);
});

it('should update a product', function () {
    $oldLabel = fake()->name;
    $category = Category::factory()->create(['label' => $oldLabel]);

    $newLabel   = fake()->name;
    $productDto = new ProductDto(label: $newLabel);
    $this->mockProductRepository
        ->shouldReceive('update')
        ->once()
        ->with($category->id, ['label' => $newLabel])
        ->andReturn(true);

    $productService = app(ProductServiceContract::class);

    $result = $productService->update(modelId: $category->id, productDto: $productDto);

    $this->assertTrue($result);
});
