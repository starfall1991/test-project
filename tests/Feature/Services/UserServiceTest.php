<?php

use App\Dtos\CategoryDto;
use App\Dtos\UserDto;
use App\Models\Category;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryContract;
use App\Services\CategoryService;
use App\Services\Contracts\UserServiceContract;

beforeEach(function () {
    $this->mockUserepository = Mockery::mock(UserRepositoryContract::class);
    $this->app->instance(UserRepositoryContract::class, $this->mockUserepository);
});

it('should return a list of users', function () {
    $users = User::factory()->count(10)->create();

    $this->mockUserepository->shouldReceive('get')->once()->andReturn($users);

    $userService = app(UserServiceContract::class);

    $result = $userService->get();

    $this->assertInstanceOf(expected: User::class, actual: $result->random()->first());
    $this->assertEquals(expected: $users->toArray(), actual: $result->toArray());
});

it('should create a new user', function () {
    $userRaw = [
        'email'    => fake()->email,
        'password' => fake()->password,
    ];
    $userDto = new UserDto(email: $userRaw['email'], password: $userRaw['password']);
    $this->mockUserepository
        ->shouldReceive('create')
        ->once()
        //        ->with(['email' => $userRaw['email'], 'password' => Hash::make($userRaw['password'])])
        ->andReturn(new User());

    $userService = app(UserServiceContract::class);

    $result = $userService->create($userDto);

    $this->assertInstanceOf(expected: User::class, actual: $result);
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

    $categoryService = app(CategoryService::class);

    $result = $categoryService->update(modelId: $category->id, categoryDto: $categoryDto);

    $this->assertTrue($result);
});
