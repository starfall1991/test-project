<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryProductStoreRequest;
use App\Http\Resources\CategoryProductResource;
use App\Services\Contracts\ProductServiceContract;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;

class CategoryProductController extends Controller
{
    public function __construct(
        protected ProductServiceContract $productService,
    ) {
    }

    public function index(int $product): AnonymousResourceCollection
    {
        return CategoryProductResource::collection($this->productService->getCategories($product));
    }

    public function store(CategoryProductStoreRequest $request, int $product): \Illuminate\Http\Response
    {
        $this->productService->syncCategories(
            $product,
            $request->input('categoryIds')
        );

        return response()
            ->noContent()
            ->setStatusCode(Response::HTTP_CREATED);
    }
}
