<?php

namespace App\Http\Controllers;

use App\Dtos\ProductDto;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Services\Contracts\ProductServiceContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function __construct(
        protected ProductServiceContract $productService,
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        return ProductResource::collection($this->productService->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request): JsonResponse
    {
        $productDto = new ProductDto(
            label: $request->input('label'),
        );

        return ProductResource::make($this->productService->create($productDto))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $product): JsonResponse
    {
        return ProductResource::make($this->productService->show($product));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request, int $product): \Illuminate\Http\Response
    {
        $productDto = new ProductDto(label: $request->input('label'));

        $this->productService->update(modelId: $product, productDto: $productDto);

        return response()
            ->noContent()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $product): \Illuminate\Http\Response
    {
        $this->productService->delete(modelId: $product);

        return response()
            ->noContent()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }
}
