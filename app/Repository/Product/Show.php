<?php

declare(strict_types=1);

namespace App\Repository\Product;

use App\Repository\AbstractRepository;
use Illuminate\Support\Facades\DB;

/**
 * Class Show
 */
final class Show
{
    /**
     * @param int $productId
     * @param AbstractRepository $repository
     * @return array<string, mixed>
     */
    public function show(int $productId, AbstractRepository $repository): array
    {
        $product = [];
        $result = $repository->getQuery()
            ->where('id', $productId)
            ->first();

        if ($result) {
            $category = DB::table('product_to_category')->where('product_id', $productId)->pluck('category_id')
                ->toArray();
            $number = DB::table('product_to_number')->where('product_id', $productId)->pluck('number')
                ->toArray();
            $oe = DB::table('product_to_oe')->where('product_id', $productId)->pluck('oe')
                ->toArray();
            $tnved = DB::table('product_to_tnved')->where('product_id', $productId)->pluck('tnved')
                ->toArray();
            $hscode = DB::table('product_to_hscode')->where('product_id', $productId)->pluck('hscode')
                ->toArray();

            $product['id'] = $result->id;
            $product['name'] = $result->name;
            $product['brandId'] = $result->brand_id;
            $product['widthBox'] = $result->width_box;
            $product['heightBox'] = $result->height_box;
            $product['lengthBox'] = $result->length_box;
            $product['weightGross'] = $result->weight_gross;
            $product['volume'] = $result->volume;
            $product['deposit'] = $result->deposit;
            $product['category'] = $category;
            $product['number'] = $number;
            $product['oe'] = $oe;
            $product['tnved'] = $tnved;
            $product['hscode'] = $hscode;
        }

        return $product;
    }
}
