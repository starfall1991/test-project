<?php

use App\Dtos\CategoryDto;
use App\Models\Category;
use App\Services\Contracts\CategoryServiceContract;
use Symfony\Component\HttpFoundation\Response;

beforeEach(function () {
    $this->mockCategoryService = Mockery::mock(CategoryServiceContract::class);
    $this->app->instance(CategoryServiceContract::class, $this->mockCategoryService);
});

it('should return a list of categories', function () {
    $categories = Category::factory()->count(10)->create();

    $this->mockCategoryService->shouldReceive('get')->once()->andReturn(collect($categories));

    $response = $this->get(route('categories.index'));

    $response->assertJsonCount(10, 'data');

    $response->assertStatus(Response::HTTP_OK);
});

it('should create a new category', function () {
    $label = fake()->name;
    $categoryDto = new CategoryDto(label: $label);
    $this->mockCategoryService
        ->shouldReceive('create')
        ->once()
        ->with(
            Mockery::on(static fn(CategoryDto $userDtoMock) => $userDtoMock->getLabel() === $label)
        )
        ->andReturn(new Category());

    $response = $this->post(
        route('categories.store'),
        ['label' => $categoryDto->getLabel()]
    );

    $response->assertJsonStructure(['id', 'label', 'updatedAt', 'createdAt']);

    $response->assertStatus(Response::HTTP_CREATED);
});
