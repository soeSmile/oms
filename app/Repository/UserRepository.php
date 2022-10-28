<?php

declare(strict_types=1);

namespace App\Repository;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserRepository
 */
final class UserRepository extends AbstractRepository
{
    /**
     * @var string
     */
    protected string $table = 'users';

    /**
     * @param array $data
     * @return LengthAwarePaginator|Collection
     */
    public function getAll(array $data = []): LengthAwarePaginator|Collection
    {
        if (!isAdmin()) {
            $this->query->where('deleted', false);
        }

        return parent::getAll($data);
    }

    /**
     * @param mixed $id
     * @param string $column
     * @return object|null
     */
    public function show(mixed $id, string $column = 'id'): ?object
    {
        $query = $this->getQuery();

        if (!isAdmin()) {
            $query->where('deleted', false);
        }

        return $query->where($column, $id)->first();
    }

    /**
     * @param int $id
     * @param bool $confirm
     * @return bool
     */
    public function confirm(int $id, bool $confirm = false): bool
    {
        return (bool)$this->getQuery()->where('id', $id)
            ->where('id', '<>', 1)
            ->update(['confirm' => $confirm]);
    }

    /**
     * @param array<string> $data
     * @return int
     */
    public function store(array $data): int
    {
        return $this->getQuery()->insertGetId($this->getData($data));
    }

    /**
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        return (bool)$this->getQuery()->where('id', $id)
            ->where('deleted', false)
            ->update($this->getData($data));
    }

    /**
     * @param int $id
     * @return bool
     */
    public function destroy(int $id): bool
    {
        return (bool)$this->getQuery()->where('id', $id)->update(['deleted' => true, 'confirm' => false]);
    }

    /**
     * @param array $data
     * @return array<string, mixed>
     */
    private function getData(array $data): array
    {
        $array = [];

        foreach ($data as $key => $item) {
            if ($key === 'password') {
                if ($item) {
                    $item = Hash::make($item);
                } else {
                    continue;
                }
            }

            $array[$key] = $item;
        }

        return $array;
    }
}
