<?php

declare(strict_types=1);

namespace App\Repository\Good;

use App\Repository\AbstractRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * Class Update
 */
class Update
{
    /**
     * @param int $id
     * @param GoodDto $dto
     * @param AbstractRepository $repository
     * @return bool
     */
    public function update(int $id, GoodDto $dto, AbstractRepository $repository): bool
    {
        $result = true;

        DB::beginTransaction();

        try {
            $repository->getQuery()->where('id', $id)->lockForUpdate()->update($dto->storeData());
            DB::table('good_to_category')->where('good_id', $id)->delete();
            DB::table('good_to_number')->where('good_id', $id)->delete();
            DB::table('good_to_oe')->where('good_id', $id)->delete();
            DB::table('good_to_tnved')->where('good_id', $id)->delete();
            DB::table('good_to_hscode')->where('good_id', $id)->delete();

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
            Log::error('Update good', [$exception->getMessage()]);
            DB::rollBack();
            $result = false;
        }

        return $result;
    }
}
