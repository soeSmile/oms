<?php

declare(strict_types=1);

namespace App\Repository;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

/**
 * Class CategoryRepository
 */
final class CategoryRepository extends AbstractRepository
{
    /**
     * @var string
     */
    protected string $table = 'categories';

    /**
     * @param array $data
     * @return LengthAwarePaginator|Collection
     */
    public function getAll(array $data): LengthAwarePaginator|Collection
    {
        $this->query
            ->join('translate_category', $this->table . 'id', 'translate_category.category_id')
            ->where('locale', app()->getLocale());

        return parent::getAll($data);
    }
}
