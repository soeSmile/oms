<?php

declare(strict_types=1);

namespace App\Repository;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

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
     * @param array $data
     * @return LengthAwarePaginator|Collection
     */
    public function getAll(array $data = []): LengthAwarePaginator|Collection
    {
        $this->query->select('goods.*', 'b.name as brand')
            ->join('brands as b', 'goods.brand_id', '=', 'b.id')
            ->orderBy('goods.id');

        return parent::getAll($data);
    }

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