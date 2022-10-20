<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeed extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        foreach (range(1, 1000) as $item) {
            DB::table('categories')->insert([
                'code' => fake()->numerify(),
                'name' => fake()->sentence(3)
            ]);
        }
    }
}
