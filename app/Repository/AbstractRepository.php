<?php

declare(strict_types=1);

namespace App\Repository;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Abstract class AbstractRepository
 */
abstract class AbstractRepository
{
    /**
     * @var string
     */
    protected string $table;

    /**
     * @var int
     */
    protected int $perPage = 25;

    /**
     * @var Builder
     */
    protected readonly Builder $query;

    /**
     *
     */
    public function __construct()
    {
        $this->query = $this->getQuery();
    }

    /**
     * @param array $data
     * @return LengthAwarePaginator|Collection
     */
    public function getAll(array $data = []): LengthAwarePaginator|Collection
    {
        if (isset($data['paginate'])) {
            return $this->query->paginate($this->perPage);
        }

        return $this->query->get();
    }

    /**
     * @param mixed $id
     * @param string $column
     * @return Object|null
     */
    public function show(mixed $id, string $column = 'id'): ?object
    {
        return $this->getQuery()->where($column, $id)->first();
    }

    /**
     * @return Builder
     */
    public function getQuery(): Builder
    {
        return DB::table($this->table);
    }

    /**
     * @return string
     */
    public function getTable(): string
    {
        return $this->table;
    }
}
