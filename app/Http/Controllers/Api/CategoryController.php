<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

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

    public function show(int $category)
    {
    }

    public function store()
    {
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
