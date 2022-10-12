<?php

declare(strict_types=1);

namespace App\Repository;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AbstractRepository
 */
abstract class AbstractRepository
{
    /**
     * @var int
     */
    protected int $paginateCount = 25;

    /**
     * @var Builder
     */
    protected readonly Builder $query;

    public function __construct(private readonly Model $model)
    {
        $this->query = $this->model::query();
    }

    /**
     * @return Builder
     */
    public function getQuery(): Builder
    {
        return $this->model::query();
    }

    /**
     * @param array $data
     * @return LengthAwarePaginator|Builder[]|Collection
     */
    public function getAll(array $data): Collection|LengthAwarePaginator|array
    {
        if (isset($data['paginate'])) {
            return $this->query->paginate($this->paginateCount);
        }

        return $this->query->get();
    }
}
