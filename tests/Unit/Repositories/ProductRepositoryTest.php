<?php

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryContract;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

it('should return a list of products', function () {
    $products = Product::factory()->count(10)->create();

    $productRepository = app(ProductRepositoryContract::class);

    $result = $productRepository->get();

    $this->assertInstanceOf(expected: Product::class, actual: $result->random()->first());
    $this->assertEquals(expected: $products->toArray(), actual: $result->toArray());
});

it('should create a new product', function () {
    $label             = fake()->name;
    $productRepository = app(ProductRepositoryContract::class);

    $result = $productRepository->create(['label' => $label]);

    $this->assertInstanceOf(expected: Product::class, actual: $result);
    $this->assertDatabaseCount(table: Product::class, count: 1);
    $this->assertDatabaseHas(Product::class, ['label' => $label]);
});

it('should update a product', function () {
    $oldLabel = fake()->name;
    $product  = Product::factory()->create(['label' => $oldLabel]);

    $newLabel = fake()->name;

    $productRepository = app(ProductRepositoryContract::class);

    $result = $productRepository->update($product->id, ['label' => $newLabel]);

    $this->assertTrue($result);
    $this->assertDatabaseHas(Product::class, ['label' => $newLabel]);
    $this->assertDatabaseMissing(Product::class, ['label' => $oldLabel]);
});
