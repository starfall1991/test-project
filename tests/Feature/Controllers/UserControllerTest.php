<?php

use App\Dtos\UserDto;
use App\Models\User;
use App\Services\Contracts\UserServiceContract;
use Symfony\Component\HttpFoundation\Response;

beforeEach(function () {
    $this->mockUserService = Mockery::mock(UserServiceContract::class);
    $this->app->instance(UserServiceContract::class, $this->mockUserService);
});

it('should return a list of users', function () {
    $users = User::factory()->count(10)->create();

    $this->mockUserService->shouldReceive('get')->once()->andReturn(collect($users));

    $response = $this->get(route('users.index'));

    $response->assertJsonCount(10, 'data');

    $response->assertStatus(Response::HTTP_OK);
});

it('should create a new user', function () {
    $email = fake()->email;
    $password = fake()->password(8);
    $userDto = new UserDto(email: $email, password: $password);
    $this->mockUserService
        ->shouldReceive('create')
        ->once()
        ->with(
            Mockery::on(static fn(UserDto $userDto) => $userDto->getEmail() === $email
                && $userDto->getPassword() === $password)
        )
        ->andReturn(new User());

    $response = $this->post(
        route('users.store'),
        ['email' => $userDto->getEmail(), 'password' => $userDto->getPassword()]
    );

    $response->assertJsonStructure(['id', 'name', 'email', 'emailVerifiedAt', 'updatedAt', 'createdAt']);

    $response->assertStatus(Response::HTTP_CREATED);
});
