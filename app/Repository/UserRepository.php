<?php

declare(strict_types=1);

namespace App\Repository;

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
        return $this->getQuery()->insertGetId($data);
    }
}
