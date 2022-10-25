<?php

declare(strict_types=1);

namespace App\Repository\Good;

use App\Repository\AbstractRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class Store
{
    /**
     * @param GoodDto $dto
     * @param AbstractRepository $repository
     * @return int
     */
    public function store(GoodDto $dto, AbstractRepository $repository): int
    {
        DB::beginTransaction();

        try {
            $id = $repository->getQuery()->insertGetId($dto->storeData());

            if ($dto->hasCategory()) {
                DB::table('good_to_category')->insert($dto->category($id));
            }

            if ($dto->hasNumber()) {
                DB::table('good_to_number')->insert($dto->number($id));
            }

            if ($dto->hasOe()) {
                DB::table('good_to_oe')->insert($dto->oe($id));
            }

            if ($dto->hasTnved()) {
                DB::table('good_to_tnved')->insert($dto->tnved($id));
            }

            if ($dto->hasHscode()) {
                DB::table('good_to_hscode')->insert($dto->hscode($id));
            }

            DB::commit();
        } catch (Throwable $exception) {
            Log::error('Error sore good:', [$exception->getMessage()]);
            DB::rollBack();
            $id = 0;
        }

        return $id;
    }
}
