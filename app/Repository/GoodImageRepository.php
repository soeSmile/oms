<?php

declare(strict_types=1);

namespace App\Repository;

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
     * @param int $id
     * @return Object|null
     */
    public function show(int $id): ?object
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
