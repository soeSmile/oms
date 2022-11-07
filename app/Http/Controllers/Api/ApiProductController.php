<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\Product\ProductStoreRequest;
use App\Http\Resources\Product\ProductListResource;
use App\Repository\ProductsRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;

final class ApiProductController
{
    /**
     * @param ProductsRepository $productsRepository
     */
    public function __construct(private readonly ProductsRepository $productsRepository)
    {
    }

    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $result = $this->productsRepository->getAll($request->all());

        return ProductListResource::collection($result)
            ->additional([
                'count' => $result->isNotEmpty() ? $result->first()->all : 0
            ]);
    }

    /**
     * @param int $product
     * @return JsonResponse
     */
    public function show(int $product): JsonResponse
    {
        return response()->json(['data' => $this->productsRepository->showProduct($product)]);
    }

    /**
     * @param ProductStoreRequest $request
     * @return JsonResponse
     */
    public function store(ProductStoreRequest $request): JsonResponse
    {
        $result = $this->productsRepository->store($request->validated());

        return response()->json(['data' => $result], $result ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }

    /**
     * @param int $product
     * @param ProductStoreRequest $request
     * @return JsonResponse
     */
    public function update(int $product, ProductStoreRequest $request): JsonResponse
    {
        $result = $this->productsRepository->update($product, $request->validated());

        return response()->json(['data' => $result], $result ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }

    /**
     * @param int $brand
     * @return JsonResponse
     */
    public function destroy(int $brand): JsonResponse
    {
        $result = $this->productsRepository->destroy($brand);

        return response()->json(['data' => $result], $result ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
