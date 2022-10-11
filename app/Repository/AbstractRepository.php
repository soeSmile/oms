<?php

declare(strict_types=1);

namespace App\Repository;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Class AbstractRepository
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
    protected int $paginateCount = 25;

    /**
     * @var Builder
     */
    protected Builder $query;

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
    public function getAll(array $data): LengthAwarePaginator|Collection
    {
        if (isset($data['column'])) {
            $this->query->orderBy($data['column'], $data['order'] ?? 'desc');
        } else {
            $this->query->oldest('id');
        }

        if (isset($data['all'])) {
            return $this->query->get();
        }

        return $this->query->paginate($this->paginateCount);
    }

    /**
     * @return Builder
     */
    protected function getQuery(): Builder
    {
        return DB::table($this->table)->newQuery();
    }
}
