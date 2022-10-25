<?php

declare(strict_types=1);

namespace App\Repository\Good;

use App\Repository\AbstractRepository;
use Illuminate\Support\Collection;

use function array_unique;

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
        $category = [];
        $number = [];
        $oe = [];
        $tnved = [];
        $hscode = [];
        $result = $repository->getQuery()
            ->leftJoin('good_to_category as gc', 'goods.id', '=', 'gc.good_id')
            ->leftJoin('good_to_number as gn', 'goods.id', '=', 'gn.good_id')
            ->leftJoin('good_to_oe as go', 'goods.id', '=', 'go.good_id')
            ->leftJoin('good_to_tnved as gt', 'goods.id', '=', 'gt.good_id')
            ->leftJoin('good_to_hscode as gh', 'goods.id', '=', 'gh.good_id')
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
                $category[] = $item->category_id;
            }

            if ($item->number) {
                $number[] = $item->number;
            }

            if ($item->oe) {
                $oe[] = $item->oe;
            }

            if ($item->tnved) {
                $tnved[] = $item->tnved;
            }

            if ($item->hscode) {
                $hscode[] = $item->hscode;
            }
        }

        $good->put('category', array_unique($category));
        $good->put('number', array_unique($number));
        $good->put('oe', array_unique($oe));
        $good->put('tnved', array_unique($tnved));
        $good->put('hscode', array_unique($hscode));

        return $good;
    }
}
