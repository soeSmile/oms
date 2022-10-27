<?php

declare(strict_types=1);

namespace App\Repository\Good;

use App\Jobs\RemoveGoodImagesJob;
use App\Repository\AbstractRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class Store
{
    /**
     * @var array<string>
     */
    private const DELETE_TABLE = [
        'good_to_category',
        'good_to_number',
        'good_to_oe',
        'good_to_tnved',
        'good_to_hscode',
        'good_to_image'
    ];

    /**
     * @var array<string>
     */
    private const UPDATE_TABLE = [
        'good_to_category',
        'good_to_number',
        'good_to_oe',
        'good_to_tnved',
        'good_to_hscode',
    ];

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
            $this->insertData($dto, $id);

            DB::commit();
        } catch (Throwable $exception) {
            Log::error('Error store good:', [$exception->getMessage()]);
            DB::rollBack();
            $id = 0;
        }

        return $id;
    }

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

            foreach (self::UPDATE_TABLE as $item) {
                DB::table($item)->where('good_id', $id)->delete();
            }

            $this->insertData($dto, $id);

            DB::commit();
        } catch (Throwable $exception) {
            Log::error('Error update good', [$exception->getMessage()]);
            DB::rollBack();
            $result = false;
        }

        return $result;
    }

    /**
     * @param int $id
     * @param AbstractRepository $repository
     * @return bool
     */
    public function destroy(int $id, AbstractRepository $repository): bool
    {
        $result = true;
        $queryImages = DB::table('good_to_image')->where('good_id', $id)->get()->toArray();

        DB::beginTransaction();

        try {
            $repository->getQuery()->where('id', $id)->delete();

            foreach (self::DELETE_TABLE as $item) {
                DB::table($item)->where('good_id', $id)->delete();
            }

            DB::commit();
        } catch (Throwable $exception) {
            Log::error('Error destroy good', [$exception->getMessage()]);
            DB::rollBack();
            $result = false;
        }

        if ($result) {
            dispatch(new RemoveGoodImagesJob($queryImages));
        }

        return $result;
    }

    /**
     * @param GoodDto $dto
     * @param int $id
     * @return void
     */
    private function insertData(GoodDto $dto, int $id): void
    {
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
    }
}
