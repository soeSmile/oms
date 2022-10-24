<?php

declare(strict_types=1);

namespace App\Repository;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

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
        if (isset($data['name'])) {
            $this->query->where('name', 'ilike', '%' . $data['name'] . '%');
        }

        return parent::getAll($data);
    }

    /**
     * @param mixed $id
     * @return Collection
     */
    public function show(mixed $id): Collection
    {
        return collect();
    }

    /**
     * @param array $data
     * @return int
     */
    public function store(array $data): int
    {
        return $this->getQuery()->insertGetId($data);
    }

    /**
     * @param mixed $id
     * @param array $data
     * @return bool
     */
    public function update(mixed $id, array $data): bool
    {
        return (bool)$this->getQuery()
            ->where('id', $id)
            ->update($data);
    }

    /**
     * @param mixed $id
     * @return bool
     */
    public function destroy(mixed $id): bool
    {
        $result = true;
        $category = $this->getQuery()->where('id', $id)->first();

        DB::beginTransaction();

        try {
            if ($category) {
                $this->getQuery()->where('id', $id)->delete();
                DB::table('goods')->where('brand_id', $id)->update(['brand_id' => null]);
                DB::commit();
            }
        } catch (Throwable $exception) {
            Log::error('Error delete Brand', [$exception->getMessage()]);
            DB::rollBack();
            $result = false;
        }

        return $result;
    }
}
