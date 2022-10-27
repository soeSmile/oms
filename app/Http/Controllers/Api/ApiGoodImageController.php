<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Resources\Good\GoodImageResource;
use App\Repository\GoodImageRepository;
use App\Services\GoodImageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ApiImageController
 */
final class ApiGoodImageController
{
    /**
     * @param GoodImageService $goodImageService
     * @param GoodImageRepository $goodImageRepository
     */
    public function __construct(
        private readonly GoodImageService $goodImageService,
        private readonly GoodImageRepository $goodImageRepository
    ) {
    }

    /**
     * @param int $good
     * @return AnonymousResourceCollection
     */
    public function images(int $good): AnonymousResourceCollection
    {
        return GoodImageResource::collection($this->goodImageRepository->getAll(['goodId' => $good]));
    }

    /**
     * @param int $good
     * @param Request $request
     * @return JsonResponse
     */
    public function upload(int $good, Request $request): JsonResponse
    {
        $file = $request->file('file');
        $result = $this->goodImageService->uploadImage($good, $file);

        return response()->json(['data' => $result], $result !== [] ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $result = $this->goodImageService->destroy($id);

        return response()->json(['data' => $result], $result ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
