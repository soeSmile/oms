<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\User\UserConfirmRequest;
use App\Http\Resources\User\UserResource;
use App\Repository\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;

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

    /**
     * @param UserConfirmRequest $request
     * @return JsonResponse
     */
    public function confirm(UserConfirmRequest $request): JsonResponse
    {
        $result = $this->repository->confirm($request->id, $request->confirm);

        return response()->json(['data' => $result], $result ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
