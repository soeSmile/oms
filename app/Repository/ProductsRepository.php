<?php

declare(strict_types=1);

namespace App\Repository;

use App\Repository\Product\ProductDto;
use App\Repository\Product\Show;
use App\Repository\Product\Store;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

/**
 * Class ProductsRepository
 */
final class ProductsRepository extends AbstractRepository
{
    /**
     * @var string
     */
    protected string $table = 'products';

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
            $this->query->where('products.name', 'ilike', '%' . $data['name'] . '%');
        }

        $this->query
            ->select('products.*', 'b.name as brand')
            ->selectRaw(
                "(select count(gc.product_id) from product_to_category as gc where gc.product_id = products.id) as count,
                (select count(id) from products) as all"
            )
            ->leftJoin('brands as b', 'products.brand_id', '=', 'b.id');

        if (isset($data['order'])) {
            $map = [
                'id'      => 'products.id',
                'name'    => 'products.name',
                'brand'   => 'b.name',
                'deposit' => 'products.deposit'
            ];

            foreach ($data['order'] as $key => $item) {
                $this->query->orderBy($map[$key], $item);
            }
        } else {
            $this->query->orderBy('products.id');
        }

        return parent::getAll($data);
    }

    /**
     * @param int $id
     * @return array
     */
    public function showProduct(int $id): array
    {
        return $this->show->show($id, $this);
    }

    /**
     * @param array $data
     * @return int
     */
    public function store(array $data): int
    {
        return $this->store->store(new ProductDto($data), $this);
    }

    /**
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        return $this->store->update($id, new ProductDto($data), $this);
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
