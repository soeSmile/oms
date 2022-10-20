<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Resources\Brand\BrandResource;
use App\Repository\BrandRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

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
}
