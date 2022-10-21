<?php

declare(strict_types=1);

namespace App\Repository;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
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

    public function __construct(private readonly GoodsRepository $goods)
    {
        parent::__construct();
    }

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
        return $this->getQuery()->insert($data);
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
                DB::table($this->goods->getTable())->where('brand_id', $id)->update(['brand_id' => null]);
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
