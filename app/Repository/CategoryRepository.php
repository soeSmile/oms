<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class CategoryRepository
 */
final class CategoryRepository extends AbstractRepository
{
    /**
     * @param Category $model
     */
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

    /**
     * @param array $data
     * @return Collection|LengthAwarePaginator|array|Builder[]
     */
    public function getAll(array $data): Collection|LengthAwarePaginator|array
    {
        $this->query->with('name');

        return parent::getAll($data);
    }
}
