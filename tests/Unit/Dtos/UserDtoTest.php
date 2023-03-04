<?php

use App\Dtos\UserDto;

it('should return an email from userDto', function () {
    $email    = fake()->email;
    $password = fake()->password(8);
    $userDto  = new UserDto(email: $email, password: $password);

    $this->assertEquals($userDto->getEmail(), $email);
});

it('should return a name from userDto', function () {
    $email    = fake()->email;
    $password = fake()->password(8);
    $name     = fake()->name;
    $userDto  = new UserDto(email: $email, password: $password, name: $name);

    $this->assertEquals($userDto->getName(), $name);
});

it('should return a password from userDto', function () {
    $email    = fake()->email;
    $password = fake()->password(8);
    $userDto  = new UserDto(email: $email, password: $password);

    $this->assertEquals($userDto->getPassword(), $password);
});

it('should return a emailVerifiedAt from userDto', function () {
    $email    = fake()->email;
    $password = fake()->password(8);
    $time     = fake()->timezone;
    $userDto  = new UserDto(email: $email, password: $password, emailVerifiedAt: $time);

    $this->assertEquals($userDto->getEmailVerifiedAt(), $time);
});

