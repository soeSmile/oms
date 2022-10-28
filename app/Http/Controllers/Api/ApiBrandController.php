<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\Brand\BrandStoreRequest;
use App\Http\Resources\Brand\BrandResource;
use App\Repository\BrandRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ApiBrandController
 */
final class ApiBrandController
{
    /**
     * @param BrandRepository $brandRepository
     */
    public function __construct(private readonly BrandRepository $brandRepository)
    {
    }

    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        return BrandResource::collection($this->brandRepository->getAll($request->all()));
    }

    /**
     * @param BrandStoreRequest $brandStoreRequest
     * @return JsonResponse
     */
    public function store(BrandStoreRequest $brandStoreRequest): JsonResponse
    {
        $result = $this->brandRepository->store($brandStoreRequest->validated());

        return response()->json(['data' => $result], $result ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
    }

    /**
     * @param int $brand
     * @param BrandStoreRequest $brandStoreRequest
     * @return JsonResponse
     */
    public function update(int $brand, BrandStoreRequest $brandStoreRequest): JsonResponse
    {
        $result = $this->brandRepository->update($brand, $brandStoreRequest->validated());

        return response()->json(['data' => $result], $result ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }

    /**
     * @param int $brand
     * @return JsonResponse
     */
    public function destroy(int $brand): JsonResponse
    {
        $result = $this->brandRepository->destroy($brand);

        return response()->json(['data' => $result], $result ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
