<?php

use App\Models\Category;
use App\Models\CategoryProduct;
use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryContract;
use App\Services\Contracts\ProductServiceContract;

beforeEach(function () {
    $this->mockProductRepository = Mockery::mock(ProductRepositoryContract::class);
    $this->app->instance(ProductRepositoryContract::class, $this->mockProductRepository);
});

it('should return a list of categories for the product', function () {
    $product          = Product::factory()->create();
    $categoryProducts = CategoryProduct::factory()->count(10)->create(['product_id' => $product->id]);

    $this->mockProductRepository->shouldReceive('getCategories')->once()->andReturn($categoryProducts);

    $productService = app(ProductServiceContract::class);

    $result = $productService->getCategories($product->id);

    $this->assertInstanceOf(expected: CategoryProduct::class, actual: $result->random()->first());
    $this->assertEquals(expected: $categoryProducts->toArray(), actual: $result->toArray());
});

it('should sync categoryIds to the product', function () {
    $product    = Product::factory()->create();
    $categories = Category::factory()->count(10)->create();

    $this->mockProductRepository
        ->shouldReceive('syncCategories')
        ->once()
        ->with(
            $product->id,
            $categories->pluck('id')->toArray()
        )
        ->andReturn(null);

    $productService = app(ProductServiceContract::class);

    $productService->syncCategories($product->id, $categories->pluck('id')->toArray());
});
