<?php

namespace App\Services;

use App\Dtos\UserDto;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryContract;
use App\Services\Contracts\UserServiceContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class UserService extends BaseCrudService implements UserServiceContract
{
    public function __construct()
    {
        $this->repository = app(UserRepositoryContract::class);
    }

    public function create(UserDto $userDto): User|Model|array
    {
        return $this->repository->create([
            'email'    => $userDto->getEmail(),
            'password' => Hash::make($userDto->getPassword()),
        ]);
    }

    public function update(int $modelId, UserDto $userDto): bool
    {
        return $this->repository->update(
            modelId: $modelId,
            payload: [
                'name'              => $userDto->getName(),
                'email'             => $userDto->getEmail(),
                'password'          => $userDto->getPassword(),
                'email_verified_at' => $userDto->getEmailVerifiedAt(),
            ],
        );
    }
}
