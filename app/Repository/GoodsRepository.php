<?php

declare(strict_types=1);

namespace App\Repository;

use App\Repository\Good\GoodDto;
use App\Repository\Good\Show;
use App\Repository\Good\Store;
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
     */
    public function __construct(
        private readonly Store $store,
        private readonly Show $show,
    ) {
        parent::__construct();
    }

    /**
     * @param array $data
     * @return LengthAwarePaginator|Collection
     */
    public function getAll(array $data = []): LengthAwarePaginator|Collection
    {
        if (isset($data['name'])) {
            $this->query->where('goods.name', 'ilike', '%' . $data['name'] . '%');
        }

        $this->query
            ->select('goods.*', 'b.name as brand')
            ->selectRaw(
                "(select count(gc.good_id) from good_to_category as gc where gc.good_id = goods.id) as count,
                (select count(id) from goods) as all"
            )
            ->leftJoin('brands as b', 'goods.brand_id', '=', 'b.id');

        if (isset($data['order'])) {
            $map = [
                'id'      => 'goods.id',
                'name'    => 'goods.name',
                'brand'   => 'b.name',
                'deposit' => 'goods.deposit'
            ];

            $this->query->orderBy($map[$data['order'][0]], $data['order'][1]);
        } else {
            $this->query->orderBy('goods.id');
        }

        return parent::getAll($data);
    }

    /**
     * @param int $id
     * @return array
     */
    public function showGood(int $id): array
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
        return $this->store->update($id, new GoodDto($data), $this);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function destroy(int $id): bool
    {
        return $this->store->destroy($id, $this);
    }
}
