<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GoodSeed extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        foreach (range(1, 100) as $item) {
            DB::table('goods')->insert([
                'name'         => fake()->sentence(2),
                'brand_id'     => fake()->numberBetween(1, 10),
                'width_box'    => fake()->randomFloat(2, 10, 100),
                'height_box'   => fake()->randomFloat(2, 10, 100),
                'length_box'   => fake()->randomFloat(2, 10, 100),
                'weight_gross' => fake()->randomFloat(2, 10, 100),
                'volume'       => fake()->randomFloat(2, 10, 100),
                'deposit'      => fake()->boolean(),
            ]);
        }
    }
}
