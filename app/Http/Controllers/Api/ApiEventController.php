<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Resources\Event\EventResource;
use App\Services\Event\EventRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Class ApiEventController
 */
final class ApiEventController
{
    /**
     * @param EventRepository $repository
     */
    public function __construct(private readonly EventRepository $repository)
    {
    }

    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        return EventResource::collection($this->repository->getAll($request->all()));
    }
}
