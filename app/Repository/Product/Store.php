<?php

declare(strict_types=1);

namespace App\Repository\Product;

use App\Jobs\RemoveProductImagesJob;
use App\Repository\AbstractRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

final class Store
{
    /**
     * @var array<string>
     */
    private const DELETE_TABLE = [
        'product_to_category',
        'product_to_number',
        'product_to_oe',
        'product_to_tnved',
        'product_to_hscode',
        'product_to_image'
    ];

    /**
     * @var array<string>
     */
    private const UPDATE_TABLE = [
        'product_to_category',
        'product_to_number',
        'product_to_oe',
        'product_to_tnved',
        'product_to_hscode',
    ];

    /**
     * @param ProductDto $dto
     * @param AbstractRepository $repository
     * @return int
     */
    public function store(ProductDto $dto, AbstractRepository $repository): int
    {
        DB::beginTransaction();

        try {
            $id = $repository->getQuery()->insertGetId($dto->storeData());
            $this->insertData($dto, $id);

            DB::commit();
        } catch (Throwable $exception) {
            Log::error('Error store product:', [$exception->getMessage()]);
            DB::rollBack();
            $id = 0;
        }

        return $id;
    }

    /**
     * @param int $id
     * @param ProductDto $dto
     * @param AbstractRepository $repository
     * @return bool
     */
    public function update(int $id, ProductDto $dto, AbstractRepository $repository): bool
    {
        $result = true;

        DB::beginTransaction();

        try {
            $repository->getQuery()->where('id', $id)->lockForUpdate()->update($dto->storeData());

            foreach (self::UPDATE_TABLE as $item) {
                DB::table($item)->where('product_id', $id)->delete();
            }

            $this->insertData($dto, $id);

            DB::commit();
        } catch (Throwable $exception) {
            Log::error('Error update product', [$exception->getMessage()]);
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
        $queryImages = DB::table('product_to_image')->where('product_id', $id)->get()->toArray();

        DB::beginTransaction();

        try {
            $repository->getQuery()->where('id', $id)->delete();

            foreach (self::DELETE_TABLE as $item) {
                DB::table($item)->where('product_id', $id)->delete();
            }

            DB::commit();
        } catch (Throwable $exception) {
            Log::error('Error destroy product', [$exception->getMessage()]);
            DB::rollBack();
            $result = false;
        }

        if ($result) {
            dispatch(new RemoveProductImagesJob($queryImages));
        }

        return $result;
    }

    /**
     * @param ProductDto $dto
     * @param int $id
     * @return void
     */
    private function insertData(ProductDto $dto, int $id): void
    {
        if ($dto->hasCategory()) {
            DB::table('product_to_category')->insert($dto->category($id));
        }

        if ($dto->hasNumber()) {
            DB::table('product_to_number')->insert($dto->number($id));
        }

        if ($dto->hasOe()) {
            DB::table('product_to_oe')->insert($dto->oe($id));
        }

        if ($dto->hasTnved()) {
            DB::table('product_to_tnved')->insert($dto->tnved($id));
        }

        if ($dto->hasHscode()) {
            DB::table('product_to_hscode')->insert($dto->hscode($id));
        }
    }
}
