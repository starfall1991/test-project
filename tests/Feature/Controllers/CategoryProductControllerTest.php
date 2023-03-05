<?php

use App\Models\Category;
use App\Models\CategoryProduct;
use App\Models\Product;
use App\Services\Contracts\ProductServiceContract;
use Symfony\Component\HttpFoundation\Response;

beforeEach(function () {
    $this->mockProductService = Mockery::mock(ProductServiceContract::class);
    $this->app->instance(ProductServiceContract::class, $this->mockProductService);
});

it('should return a list of categories of the product', function () {
    $product          = Product::factory()->create();
    $categoryProducts = CategoryProduct::factory()->count(10)->create(['product_id' => $product->id]);

    $this->mockProductService->shouldReceive('getCategories')->once()->andReturn(collect($categoryProducts));

    $response = $this->get(route('categoryProducts.index', $product->id));

    $response->assertJsonCount(10, 'data');

    $response->assertStatus(Response::HTTP_OK);
});

it('should sync categoryIds to the product', function () {
    $product    = Product::factory()->create();
    $categories = Category::factory()->count(10)->create();

    $this->mockProductService
        ->shouldReceive('syncCategories')
        ->once()
        ->with(
            $product->id,
            $categories->pluck('id')->toArray()
        )
        ->andReturn(null);

    $response = $this->post(
        route('categoryProducts.store', $product->id),
        ['categoryIds' => $categories->pluck('id')->toArray()]
    );

    $response->assertStatus(Response::HTTP_CREATED);
});
