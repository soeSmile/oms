<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeed extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        foreach (range(1, 10) as $item) {
            DB::table('brands')->insert([
                'name' => fake()->company()
            ]);
        }
    }
}
