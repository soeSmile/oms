<?php

declare(strict_types=1);

namespace App\Repository;

use Illuminate\Database\Eloquent\Model;

/**
 * Class GoodsRepository
 */
final class GoodsRepository extends AbstractRepository
{
    /**
     * @var string
     */
    protected string $table = 'goods';

    /**
     * @param mixed $id
     * @return Model|null
     */
    public function show(mixed $id): Model|null
    {
        return $this->getQuery()->where('id', $id)->first();
    }

    /**
     * @param array $data
     * @return bool
     */
    public function store(array $data): bool
    {
        return true;
    }

    /**
     * @param mixed $id
     * @param array $data
     * @return bool
     */
    public function update(mixed $id, array $data): bool
    {
        return true;
    }

    /**
     * @param mixed $id
     * @return bool
     */
    public function destroy(mixed $id): bool
    {
        return true;
    }
}