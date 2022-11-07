<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeed extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        foreach (range(1, 10000) as $item) {
            $id = DB::table('products')->insertGetId([
                'name'         => fake()->sentence(2),
                'brand_id'     => fake()->numberBetween(1, 10),
                'width_box'    => fake()->randomFloat(2, 10, 100),
                'height_box'   => fake()->randomFloat(2, 10, 100),
                'length_box'   => fake()->randomFloat(2, 10, 100),
                'weight_gross' => fake()->randomFloat(2, 10, 100),
                'volume'       => fake()->randomFloat(2, 10, 100),
                'deposit'      => fake()->boolean(),
            ]);

            foreach (range(1, 5) as $value) {
                DB::table('product_to_category')->insert([
                    'product_id'     => $id,
                    'category_id' => fake()->numberBetween(1, 20)
                ]);

                DB::table('product_to_number')->insert([
                    'product_id' => $id,
                    'number'  => fake()->ean13()
                ]);

                DB::table('product_to_oe')->insert([
                    'product_id' => $id,
                    'oe'      => fake()->ean13()
                ]);

                DB::table('product_to_tnved')->insert([
                    'product_id' => $id,
                    'tnved'   => fake()->ean13()
                ]);

                DB::table('product_to_hscode')->insert([
                    'product_id' => $id,
                    'hscode'  => fake()->ean13()
                ]);
            }
        }
    }
}
