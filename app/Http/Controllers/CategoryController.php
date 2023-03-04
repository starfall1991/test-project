<?php

namespace App\Http\Controllers;

use App\Dtos\CategoryDto;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Http\Resources\CategoryResource;
use App\Services\Contracts\CategoryServiceContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    public function __construct(
        protected CategoryServiceContract $categoryService,
    ) {
    }

    public function index(): AnonymousResourceCollection
    {
        return CategoryResource::collection($this->categoryService->get());
    }

    public function store(CategoryStoreRequest $request): JsonResponse
    {
        $categoryDto = new CategoryDto(label: $request->input('label'));

        return CategoryResource::make($this->categoryService->create($categoryDto))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(int $category): JsonResponse
    {
        return CategoryResource::make($this->categoryService->show($category));
    }

    public function update(CategoryUpdateRequest $request, int $category): \Illuminate\Http\Response
    {
        $categoryDto = new CategoryDto(label: $request->input('label'));

        $this->categoryService->update(modelId: $category, categoryDto: $categoryDto);

        return response()
            ->noContent()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(int $category): \Illuminate\Http\Response
    {
        $this->categoryService->delete(modelId: $category);

        return response()
            ->noContent()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }
}
