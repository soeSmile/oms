<?php

declare(strict_types=1);

namespace App\Repository;

use Illuminate\Database\Query\Builder;
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
     * @return Builder
     */
    protected function getQuery(): Builder
    {
        return DB::table($this->table);
    }
}
