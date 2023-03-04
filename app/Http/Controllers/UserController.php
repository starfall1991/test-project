<?php

namespace App\Http\Controllers;

use App\Dtos\UserDto;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Services\Contracts\UserServiceContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function __construct(
        protected UserServiceContract $userService,
    ) {
    }

    public function index(): AnonymousResourceCollection
    {
        return UserResource::collection($this->userService->get());
    }

    public function store(UserStoreRequest $request): JsonResponse
    {
        $userDto = new UserDto(
            email: $request->input('email'),
            password: $request->input('password'),
        );

        return UserResource::make($this->userService->create($userDto))->response()->setStatusCode(
            Response::HTTP_CREATED
        );
    }

    public function show(int $user): JsonResponse
    {
        return UserResource::make($this->userService->show($user))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function update(UserUpdateRequest $request, int $user): \Illuminate\Http\Response
    {
        $userDto = new UserDto(
            email: $request->input('email'),
            password: $request->input('password'),
            name: $request->input('name'),
        );
        $this->userService->update($user, $userDto);

        return response()
            ->noContent()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(int $user): \Illuminate\Http\Response
    {
        $this->userService->delete($user);

        return response()
            ->noContent()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }
}
