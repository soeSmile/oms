<?php

declare(strict_types=1);

namespace App\Repository\Good;

use App\Repository\AbstractRepository;
use Illuminate\Support\Facades\DB;

/**
 * Class Show
 */
class Show
{
    /**
     * @param int $goodId
     * @param AbstractRepository $repository
     * @return array<string, mixed>
     */
    public function show(int $goodId, AbstractRepository $repository): array
    {
        $good = [];
        $result = $repository->getQuery()
            ->where('id', $goodId)
            ->first();

        if ($result) {
            $category = DB::table('good_to_category')->where('good_id', $goodId)->pluck('category_id')->toArray();
            $number = DB::table('good_to_number')->where('good_id', $goodId)->pluck('number')->toArray();
            $oe = DB::table('good_to_oe')->where('good_id', $goodId)->pluck('oe')->toArray();
            $tnved = DB::table('good_to_tnved')->where('good_id', $goodId)->pluck('tnved')->toArray();
            $hscode = DB::table('good_to_hscode')->where('good_id', $goodId)->pluck('hscode')->toArray();

            $good['id'] = $result->id;
            $good['name'] = $result->name;
            $good['brandId'] = $result->brand_id;
            $good['widthBox'] = $result->width_box;
            $good['heightBox'] = $result->height_box;
            $good['lengthBox'] = $result->length_box;
            $good['weightGross'] = $result->weight_gross;
            $good['volume'] = $result->volume;
            $good['deposit'] = $result->deposit;
            $good['category'] = $category;
            $good['number'] = $number;
            $good['oe'] = $oe;
            $good['tnved'] = $tnved;
            $good['hscode'] = $hscode;
        }

        return $good;
    }
}
