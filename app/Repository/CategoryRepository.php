<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\Category;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Class CategoryRepository
 */
final class CategoryRepository
{
    /**
     * @param array<string> $data
     * @return Collection<string, object>
     */
    public function getAll(array $data): Collection
    {
        $query = $this->getQuery()
            ->select('id', 'name', 'parent_id as parentId', 'code')
            ->selectRaw('(select name from categories as c where c.id = categories.parent_id) as parent')
            ->selectRaw('(select count(id) from categories as c where c.id = categories.parent_id) as count');

        if (isset($data['first'])) {
            $query->whereNull('parent_id');
        }

        return $query->get();
    }


    /**
     * @param array $data
     * @return bool
     */
    public function store(array $data): bool
    {
        return $this->getQuery()->insert($this->getData($data));
    }

    /**
     * @param int $categoryId
     * @param array<string> $data
     * @return bool
     */
    public function update(int $categoryId, array $data): bool
    {
        return (bool)$this->getQuery()
            ->where('id', $categoryId)
            ->update($this->getData($data));
    }

    /**
     * @return array<string>
     */
    public function getTree(): array
    {
        $data = $this->getQuery()
            ->select('id', 'name as label', 'code', 'parent_id as parentId')
            ->selectRaw('(select name from categories as c where c.id = categories.parent_id) as parent')
            ->orderBy('name')
            ->get();

        $data = $data->toArray();

        return $this->buildTree($data);
    }

    /**
     * @param array<string> $data
     * @param int $parentId
     * @return array<string>
     */
    private function buildTree(array &$data, int $parentId = 0): array
    {
        $result = [];

        foreach ($data as $item) {
            if ((int)$item->parentId === $parentId) {
                $child = $this->buildTree($data, (int)$item->id);

                if ($child) {
                    $item->children = $child;
                }

                $result[] = $item;

                unset($data[$item->id]);
            }
        }

        return $result;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function destroy(int $id): bool
    {
        // TODO отвязывать категорию от товара
        $result = true;
        $category = $this->getQuery()->where('id', $id)->first();

        DB::beginTransaction();

        try {
            if ($category) {
                $this->getQuery()->where('id', $id)->delete();
                $this->getQuery()->where('parent_id', $id)->update(['parent_id' => $category->parent_id]);
                DB::commit();
            }
        } catch (\Throwable $exception) {
            DB::rollBack();
            $result = false;
        }

        return $result;
    }

    /**
     * @param array<string> $data
     * @return array<string, string|null>
     */
    private function getData(array $data): array
    {
        return [
            'name'      => $data['name'],
            'parent_id' => $data['parentId'] ?? null,
            'code'      => $data['code'] ?? null
        ];
    }

    /**
     * @return Builder
     */
    private function getQuery(): Builder
    {
        return DB::table('categories');
    }
}
