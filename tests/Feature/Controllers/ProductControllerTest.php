<?php

use App\Dtos\ProductDto;
use App\Models\Category;
use App\Models\Product;
use App\Services\Contracts\ProductServiceContract;
use Symfony\Component\HttpFoundation\Response;

beforeEach(function () {
    $this->mockProductService = Mockery::mock(ProductServiceContract::class);
    $this->app->instance(ProductServiceContract::class, $this->mockProductService);
});

it('should return a list of products', function () {
    $products = Product::factory()->count(10)->create();

    $this->mockProductService->shouldReceive('get')->once()->andReturn(collect($products));

    $response = $this->get(route('products.index'));

    $response->assertJsonCount(10, 'data');

    $response->assertStatus(Response::HTTP_OK);
});

it('should create a new product', function () {
    $label = fake()->name;
    $productDto = new ProductDto(label: $label);
    $this->mockProductService
        ->shouldReceive('create')
        ->once()
        ->with(
            Mockery::on(static fn(ProductDto $productDtoMock) => $productDtoMock->getLabel() === $label)
        )
        ->andReturn(new Category());

    $response = $this->post(
        route('products.store'),
        ['label' => $productDto->getLabel()]
    );

    $response->assertJsonStructure(['id', 'label', 'updatedAt', 'createdAt']);

    $response->assertStatus(Response::HTTP_CREATED);
});
