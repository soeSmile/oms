<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\Category\CategoryStoreRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Repository\CategoryRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Class CategoryController
 */
class CategoryController
{
    /**
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(private readonly CategoryRepository $categoryRepository)
    {
    }

    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        return CategoryResource::collection($this->categoryRepository->getAll($request->all()));
    }

    /**
     * @return JsonResponse
     */
    public function getTree(): JsonResponse
    {
        return response()->json(['data' => $this->categoryRepository->getTree()]);
    }

    public function show(int $category)
    {
    }

    /**
     * @param CategoryStoreRequest $categoryStoreRequest
     * @return CategoryResource
     */
    public function store(CategoryStoreRequest $categoryStoreRequest): CategoryResource
    {
        return new CategoryResource($this->categoryRepository->store($categoryStoreRequest->validated()));
    }

    /**
     * @param int $category
     * @return JsonResponse
     */
    public function update(int $category): JsonResponse
    {
        return response()->json();
    }

    /**
     * @param int $category
     * @return JsonResponse
     */
    public function destroy(int $category): JsonResponse
    {
        return response()->json();
    }
}
