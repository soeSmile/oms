<?php

declare(strict_types=1);

namespace App\Repository;

use App\Repository\Good\GoodDto;
use App\Repository\Good\Show;
use App\Repository\Good\Store;
use App\Repository\Good\Update;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
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
     * @param Store $store
     * @param Show $show
     * @param Update $update
     */
    public function __construct(
        private readonly Store $store,
        private readonly Show $show,
        private readonly Update $update
    ) {
        parent::__construct();
    }

    /**
     * @param array $data
     * @return LengthAwarePaginator|Collection
     */
    public function getAll(array $data = []): LengthAwarePaginator|Collection
    {
        $this->query
            ->select('goods.*', 'b.name as brand')
            ->selectRaw("(select count(gc.good_id) from good_to_category as gc where gc.good_id = goods.id) as count")
            ->leftJoin('brands as b', 'goods.brand_id', '=', 'b.id')
            ->orderBy('goods.id');

        return parent::getAll($data);
    }

    /**
     * @param int $id
     * @return Collection
     */
    public function show(int $id): Collection
    {
        return $this->show->show($id, $this);
    }

    /**
     * @param array $data
     * @return int
     */
    public function store(array $data): int
    {
        return $this->store->store(new GoodDto($data), $this);
    }

    /**
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        return $this->update->update($id, new GoodDto($data), $this);
    }
}
