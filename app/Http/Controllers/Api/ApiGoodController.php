<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Resources\Good\GoodListResource;
use App\Repository\GoodsRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

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
        return GoodListResource::collection($this->goodsRepository->getAll($request->all()));
    }
}