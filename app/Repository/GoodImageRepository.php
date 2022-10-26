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
     * @return bool
     */
    public function store(array $data): bool
    {
        return $this->getQuery()->insert([
            'path'    => $data['url'],
            'name'    => $data['name'],
            'good_id' => $data['goodId'],
        ]);
    }
}
