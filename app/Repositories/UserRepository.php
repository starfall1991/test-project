<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryContract;

class UserRepository extends BaseRepository implements UserRepositoryContract
{
    public function __construct()
    {
        $this->model = app(User::class);
    }
}
