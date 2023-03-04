<?php

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryContract;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

it('should return a list of users', function () {
    $users = User::factory()->count(10)->create();

    $userRepository = app(UserRepositoryContract::class);

    $result = $userRepository->get();

    $this->assertInstanceOf(expected: User::class, actual: $result->random()->first());
    $this->assertEquals(expected: $users->toArray(), actual: $result->toArray());
});

it('should create a new user', function () {
    $userRaw        = [
        'email'    => fake()->email,
        'password' => fake()->password,
    ];
    $userRepository = app(UserRepositoryContract::class);

    $result = $userRepository->create(['email' => $userRaw['email'], 'password' => Hash::make($userRaw['password'])]);

    $this->assertInstanceOf(expected: User::class, actual: $result);
    $this->assertDatabaseCount(table: User::class, count: 1);
    $this->assertDatabaseHas(User::class, ['email' => $userRaw['email']]);
});

it('should update a user', function () {
    $oldUserRaw = [
        'email'    => fake()->email,
        'password' => fake()->password,
    ];
    $user       =
        User::factory()->create(['email' => $oldUserRaw['email'], 'password' => Hash::make($oldUserRaw['password'])]);

    $newUserRaw     = [
        'email'    => fake()->email,
        'password' => fake()->password,
    ];
    $userRepository = app(UserRepositoryContract::class);

    $result = $userRepository->update(
        $user->id,
        ['email' => $newUserRaw['email'], 'password' => Hash::make($newUserRaw['password'])]
    );

    $this->assertTrue($result);
    $this->assertDatabaseHas(User::class, ['email' => $newUserRaw['email']]);
    $this->assertDatabaseMissing(User::class, ['email' => $oldUserRaw['email']]);
});
