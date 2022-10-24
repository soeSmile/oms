<?php

declare(strict_types=1);

namespace App\Repository\Good;

use App\Repository\AbstractRepository;
use Illuminate\Support\Collection;

/**
 * Class Show
 */
class Show
{
    /**
     * @param int $goodId
     * @param AbstractRepository $repository
     * @return Collection
     */
    public function show(int $goodId, AbstractRepository $repository): Collection
    {
        $good = collect();
        $categories = [];
        $result = $repository->getQuery()
            ->leftJoin('good_to_category as gc', 'goods.id', '=', 'gc.good_id')
            ->where('id', $goodId)
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

            if ($item->category_id) {
                $categories[] = $item->category_id;
            }
        }

        $good->put('category', $categories);

        return $good;
    }
}
