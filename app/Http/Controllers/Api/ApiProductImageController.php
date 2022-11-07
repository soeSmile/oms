<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Resources\Product\ProductImageResource;
use App\Repository\ProductImageRepository;
use App\Services\ProductImageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ApiImageController
 */
final class ApiProductImageController
{
    /**
     * @param ProductImageService $productImageService
     * @param ProductImageRepository $productImageRepository
     */
    public function __construct(
        private readonly ProductImageService $productImageService,
        private readonly ProductImageRepository $productImageRepository
    ) {
    }

    /**
     * @param int $product
     * @return AnonymousResourceCollection
     */
    public function images(int $product): AnonymousResourceCollection
    {
        return ProductImageResource::collection($this->productImageRepository->getAll(['productId' => $product]));
    }

    /**
     * @param int $product
     * @param Request $request
     * @return JsonResponse
     */
    public function upload(int $product, Request $request): JsonResponse
    {
        $file = $request->file('file');
        $result = $this->productImageService->uploadImage($product, $file);

        return response()->json(['data' => $result], $result !== [] ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $result = $this->productImageService->destroy($id);

        return response()->json(['data' => $result], $result ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
