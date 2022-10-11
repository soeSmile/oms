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
     * @var string
     */
    private string $tableTranslate = 'category_translate';

    /**
     * @param array $data
     * @return LengthAwarePaginator|Collection
     */
    public function getAll(array $data): LengthAwarePaginator|Collection
    {
        $this->query
            ->crossJoin($this->table, $this->table . '.id', $this->table . '.parent_id')
            ->join($this->tableTranslate, $this->table . '.id', $this->tableTranslate . '.category_id')
            ->where('locale', app()->getLocale())
            ->orderBy($this->table . '.id');

        return parent::getAll($data);
    }
}
