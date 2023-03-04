<?php

use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryContract;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

it('should return a list of categories', function () {
    $categories = Category::factory()->count(10)->create();

    $categoryRepository = app(CategoryRepositoryContract::class);

    $result = $categoryRepository->get();

    $this->assertInstanceOf(expected: Category::class, actual: $result->random()->first());
    $this->assertEquals(expected: $categories->toArray(), actual: $result->toArray());
});

it('should create a new category', function () {
    $label              = fake()->name;
    $categoryRepository = app(CategoryRepositoryContract::class);

    $result = $categoryRepository->create(['label' => $label]);

    $this->assertInstanceOf(expected: Category::class, actual: $result);
    $this->assertDatabaseCount(table: Category::class, count: 1);
    $this->assertDatabaseHas(Category::class, ['label' => $label]);
});

it('should update a category', function () {
    $oldLabel = fake()->name;
    $category = Category::factory()->create(['label' => $oldLabel]);

    $newLabel = fake()->name;

    $categoryRepository = app(CategoryRepositoryContract::class);

    $result = $categoryRepository->update($category->id, ['label' => $newLabel]);

    $this->assertTrue($result);
    $this->assertDatabaseHas(Category::class, ['label' => $newLabel]);
    $this->assertDatabaseMissing(Category::class, ['label' => $oldLabel]);
});
