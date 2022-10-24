<?php

declare(strict_types=1);

namespace App\Repository;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

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
     * @param mixed $id
     * @return Collection
     */
    public function show(mixed $id): Collection
    {
        $good = collect();
        $categories = [];
        $result = $this->getQuery()
            ->leftJoin('good_to_category as gc', 'goods.id', '=', 'gc.good_id')
            ->where('id', $id)
            ->get();

        foreach ($result as $item) {
            $good->put('id', $item->id);
            $good->put('name', $item->name);
            $good->put('brandId', $item->brand_id);
            $good->put('widthBox', $item->width_box);
            $good->put('heightBox', $item->height_box);
            $good->put('lengthBox', $item->length_box);
            $good->put('weightGross', $item->weight_gross);
            $good->put('volume', $item->volume);
            $good->put('deposit', $item->deposit);

            $categories[] = $item->category_id;
        }

        $good->put('category', $categories);

        return $good;
    }

    /**
     * @param array $data
     * @return int
     */
    public function store(array $data): int
    {
        $id = 0;
        DB::beginTransaction();

        try {
            $id = $this->getQuery()->insertGetId($this->prepareGoodData($data));

            if (isset($data['category'])) {
                DB::table('good_to_category')->insert($this->prepareGoodCategory($data['category'], $id));
            }

            DB::commit();
        } catch (Throwable $exception) {
            Log::error('Error sore good:', [$exception->getMessage()]);
            DB::rollBack();
        }

        return $id;
    }

    /**
     * @param mixed $id
     * @param array $data
     * @return bool
     */
    public function update(mixed $id, array $data): bool
    {
        $result = true;

        DB::beginTransaction();

        try {
            $this->getQuery()->where('id', $id)->update($this->prepareGoodData($data));

            if (isset($data['category'])) {
                DB::table('good_to_category')->where('good_id', $id)->delete();
                DB::table('good_to_category')->insert($this->prepareGoodCategory($data['category'], $id));
            }

            DB::commit();
        } catch (Throwable $exception) {
            Log::error('Update good', [$exception->getMessage()]);
            DB::rollBack();
            $result = false;
        }

        return $result;
    }

    /**
     * @param mixed $id
     * @return bool
     */
    public function destroy(mixed $id): bool
    {
        return true;
    }

    /**
     * @param array $data
     * @return array<string, mixed>
     */
    private function prepareGoodData(array $data): array
    {
        return [
            'name'         => $data['name'],
            'brand_id'     => $data['brandId'] ?? null,
            'width_box'    => $data['widthBox'] ?? null,
            'height_box'   => $data['heightBox'] ?? null,
            'length_box'   => $data['lengthBox'] ?? null,
            'weight_gross' => $data['weightGross'] ?? null,
            'volume'       => $data['volume'] ?? null,
            'deposit'      => $data['deposit'] ?? false,
        ];
    }

    /**
     * @param array $data
     * @param int $goodId
     * @return array<int, array<string, mixed>>
     */
    private function prepareGoodCategory(array $data, int $goodId): array
    {
        $array = [];

        foreach ($data as $item) {
            $array[] = ['good_id' => $goodId, 'category_id' => $item];
        }

        return $array;
    }
}
