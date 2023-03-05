<?php

use App\Models\Category;
use App\Models\CategoryProduct;
use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryContract;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

it('should return a list of categories of the product', function () {
    $product          = Product::factory()->create();
    $categoryProducts = CategoryProduct::factory()->count(10)->create(['product_id' => $product->id]);

    $productRepository = app(ProductRepositoryContract::class);

    $result = $productRepository->getCategories($product->id);

    $this->assertInstanceOf(expected: Category::class, actual: $result->random()->first());
});

it('should sync categoryIds to the product', function () {
    $product           = Product::factory()->create();
    $categories        = Category::factory()->count(10)->create();
    $productRepository = app(ProductRepositoryContract::class);

    $productRepository->syncCategories($product->id, $categories->pluck('id')->toArray());

    $this->assertDatabaseCount(table: CategoryProduct::class, count: 10);
    $this->assertDatabaseHas(CategoryProduct::class, [
        'product_id'  => $product->id,
        'category_id' => $categories->random()->first()->id,
    ]);
});
