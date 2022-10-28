<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Resources\User\UserResource;
use App\Repository\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class ApiUserController
{
    public function __construct(private readonly UserRepository $repository)
    {
    }

    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        return UserResource::collection($this->repository->getAll($request->all()));
    }
}
