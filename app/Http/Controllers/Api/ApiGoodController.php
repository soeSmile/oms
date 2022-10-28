<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\Good\GoodStoreRequest;
use App\Http\Resources\Good\GoodListResource;
use App\Repository\GoodsRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;

final class ApiGoodController
{
    /**
     * @param GoodsRepository $goodsRepository
     */
    public function __construct(private readonly GoodsRepository $goodsRepository)
    {
    }

    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $result = $this->goodsRepository->getAll($request->all());

        return GoodListResource::collection($result)
            ->additional([
                'count' => $result->isNotEmpty() ? $result->first()->all : 0
            ]);
    }

    /**
     * @param int $good
     * @return JsonResponse
     */
    public function show(int $good): JsonResponse
    {
        return response()->json(['data' => $this->goodsRepository->showGood($good)]);
    }

    /**
     * @param GoodStoreRequest $request
     * @return JsonResponse
     */
    public function store(GoodStoreRequest $request): JsonResponse
    {
        $result = $this->goodsRepository->store($request->validated());

        return response()->json(['data' => $result], $result ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }

    /**
     * @param int $good
     * @param GoodStoreRequest $request
     * @return JsonResponse
     */
    public function update(int $good, GoodStoreRequest $request): JsonResponse
    {
        $result = $this->goodsRepository->update($good, $request->validated());

        return response()->json(['data' => $result], $result ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }

    /**
     * @param int $brand
     * @return JsonResponse
     */
    public function destroy(int $brand): JsonResponse
    {
        $result = $this->goodsRepository->destroy($brand);

        return response()->json(['data' => $result], $result ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
