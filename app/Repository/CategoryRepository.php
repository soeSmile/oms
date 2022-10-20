<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class CategoryRepository
 */
final class CategoryRepository extends AbstractRepository
{
    /**
     * @param Category $model
     */
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

    /**
     * @param array $data
     * @return Collection|LengthAwarePaginator|array|Builder[]
     */
    public function getAll(array $data = []): Collection|LengthAwarePaginator|array
    {
        if (isset($data['name'])) {
            $this->query->where('name', 'like', '%' . $data['name'] . '%');
        }

        return parent::getAll($data);
    }

    /**
     * @param array<string> $data
     * @return Builder|Model
     */
    public function store(array $data): Model|Builder
    {
        return $this->getQuery()->create($this->getData($data));
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
            if ((int)$item['parentId'] === $parentId) {
                $child = $this->buildTree($data, (int)$item['id']);

                if ($child) {
                    $item['children'] = $child;
                }

                $result[] = $item;

                unset($data[$item['id']]);
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
        // TODO сделать проверку на не пустой каталог
        $result = true;
        $category = $this->getQuery()->where('id', $id)->first();

        DB::beginTransaction();

        try {
            if ($category) {
                $category->delete();
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
}
