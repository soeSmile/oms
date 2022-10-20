<?php

declare(strict_types=1);

namespace App\Repository;

use App\Repository\Contracts\ContractRepository;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

/**
 * Abstract class AbstractRepository
 */
abstract class AbstractRepository implements ContractRepository
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
     * @return Builder
     */
    protected function getQuery(): Builder
    {
        return DB::table($this->table);
    }
}
