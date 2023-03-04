<?php

namespace App\Services\Contracts;

use App\Dtos\UserDto;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

interface UserServiceContract extends BaseCrudServiceContract
{
    public function create(UserDto $userDto): User|Model|array;

    public function update(int $modelId, UserDto $userDto): bool;
}
