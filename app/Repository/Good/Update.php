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
            $repository->getQuery()->where('id', $id)->update($dto->storeData());
            DB::table('good_to_category')->where('good_id', $id)->delete();

            if ($dto->hasCategory()) {
                DB::table('good_to_category')->insert($dto->categories($id));
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
