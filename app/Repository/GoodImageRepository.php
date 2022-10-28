<?php

declare(strict_types=1);

namespace App\Repository;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

/**
 * Class GoodImageRepository
 */
final class GoodImageRepository extends AbstractRepository
{
    /**
     * @var string
     */
    protected string $table = 'good_to_image';

    /**
     * @param array $data
     * @return LengthAwarePaginator|Collection
     */
    public function getAll(array $data = []): LengthAwarePaginator|Collection
    {
        if (isset($data['goodId'])) {
            $this->query->where('good_id', $data['goodId']);
        }

        return parent::getAll($data);
    }

    /**
     * @param array $data
     * @return int
     */
    public function store(array $data): int
    {
        return $this->getQuery()->insertGetId([
            'path'    => $data['url'],
            'name'    => $data['name'],
            'good_id' => $data['goodId'],
        ]);
    }

    /**
     * @param mixed $id
     * @param string $column
     * @return Object|null
     */
    public function show(mixed $id, string $column = 'id'): ?object
    {
        return $this->getQuery()->where('id', $id)->first();
    }

    /**
     * @param int $id
     * @return bool
     */
    public function destroy(int $id): bool
    {
        return (bool)$this->getQuery()->where('id', $id)->delete();
    }
}
