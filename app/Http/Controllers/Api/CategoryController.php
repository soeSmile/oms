<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\Category\CategoryStoreRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Repository\CategoryRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

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
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return response()->json(['data' => $this->categoryRepository->getTree()]);
    }

    /**
     * @param int $category
     * @return CategoryResource
     */
    public function show(int $category): CategoryResource
    {
        return new CategoryResource($this->categoryRepository->getQuery()->where('id', $category)->first());
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
     * @param CategoryStoreRequest $categoryStoreRequest
     * @return JsonResponse
     */
    public function update(int $category, CategoryStoreRequest $categoryStoreRequest): JsonResponse
    {
        $result = $this->categoryRepository->update($category, $categoryStoreRequest->validated());

        return response()->json(['data' => $result], $result ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }

    /**
     * @param int $category
     * @return JsonResponse
     */
    public function destroy(int $category): JsonResponse
    {
        $result = $this->categoryRepository->destroy($category);

        return response()->json(['data' => $result], $result ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
