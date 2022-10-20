<?php

declare(strict_types=1);

namespace App\Repository;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class BrandRepository
 */
final class BrandRepository extends AbstractRepository
{
    /**
     * @var string
     */
    protected string $table = 'brands';

    /**
     * @param array $data
     * @return LengthAwarePaginator|Collection
     */
    public function getAll(array $data = []): LengthAwarePaginator|Collection
    {
        $query = $this->getQuery();

        if (isset($data['name'])) {
            $query->where('name', 'ilike', '%' . $data['name'] . '%');
        }

        if (isset($data['paginate'])) {
            return $query->paginate($this->perPage);
        }

        return $query->get();
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
