<?php

use App\Dtos\CategoryDto;
use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryContract;
use App\Services\Contracts\CategoryServiceContract;

beforeEach(function () {
    $this->mockCategoryRepository = Mockery::mock(CategoryRepositoryContract::class);
    $this->app->instance(CategoryRepositoryContract::class, $this->mockCategoryRepository);
});

it('should return a list of categories', function () {
    $categories = Category::factory()->count(10)->create();

    $this->mockCategoryRepository->shouldReceive('get')->once()->andReturn($categories);

    $categoryService = app(CategoryServiceContract::class);

    $result = $categoryService->get();

    $this->assertInstanceOf(expected: Category::class, actual: $result->random()->first());
    $this->assertEquals(expected: $categories->toArray(), actual: $result->toArray());
});

it('should create a new category', function () {
    $label       = fake()->name;
    $categoryDto = new CategoryDto(label: $label);
    $this->mockCategoryRepository
        ->shouldReceive('create')
        ->once()
        ->with(['label' => $label])
        ->andReturn(new Category());

    $categoryService = app(CategoryServiceContract::class);

    $result = $categoryService->create($categoryDto);

    $this->assertInstanceOf(expected: Category::class, actual: $result);
});

it('should update a category', function () {
    $oldLabel = fake()->name;
    $category = Category::factory()->create(['label' => $oldLabel]);

    $newLabel    = fake()->name;
    $categoryDto = new CategoryDto(label: $newLabel);
    $this->mockCategoryRepository
        ->shouldReceive('update')
        ->once()
        ->with($category->id, ['label' => $newLabel])
        ->andReturn(true);

    $categoryService = app(CategoryServiceContract::class);

    $result = $categoryService->update(modelId: $category->id, categoryDto: $categoryDto);

    $this->assertTrue($result);
});
