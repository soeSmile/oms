<?php

declare(strict_types=1);

namespace App\Repository\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

/**
 * Interface ContractRepository
 */
interface ContractRepository
{
    /**
     * @param array<string> $data
     * @return LengthAwarePaginator|Collection
     */
    public function getAll(array $data = []): LengthAwarePaginator|Collection;

    /**
     * @param mixed $id
     * @return Collection
     */
    public function show(mixed $id): Collection;

    /**
     * @param array<string> $data
     * @return mixed
     */
    public function store(array $data): mixed;

    /**
     * @param mixed $id
     * @param array<string> $data
     * @return bool
     */
    public function update(mixed $id, array $data): bool;

    /**
     * @param mixed $id
     * @return bool
     */
    public function destroy(mixed $id): bool;

    /**
     * @return string
     */
    public function getTable(): string;
}
