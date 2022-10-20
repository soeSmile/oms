<?php

declare(strict_types=1);

namespace App\Repository\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
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
     * @return Model|null
     */
    public function show(mixed $id): Model|null;

    /**
     * @param array<string> $data
     * @return bool
     */
    public function store(array $data): bool;

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
}
