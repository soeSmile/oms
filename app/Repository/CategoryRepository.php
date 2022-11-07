<?php

declare(strict_types=1);

namespace App\Repository;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * Class CategoryRepository
 */
final class CategoryRepository extends AbstractRepository
{
    /**
     * @var string
     */
    protected string $table = 'categories';

    /**
     * @param array<string> $data
     * @return Collection<string, object>
     */
    public function getAll(array $data = []): Collection
    {
        $query = $this->getQuery()
            ->select('id', 'name', 'parent_id as parentId', 'code')
            ->selectRaw(
                '(select name from ' . $this->table . ' as c where c.id = ' . $this->table . '.parent_id) as parent,
                (select count(id) from ' . $this->table . ' as c where c.id = ' . $this->table . '.parent_id) as count'
            );

        if (isset($data['first'])) {
            $query->whereNull('parent_id');
        }

        return $query->get();
    }

    /**
     * @param array<string> $data
     * @return int
     */
    public function store(array $data): int
    {
        return $this->getQuery()->insertGetId($this->getData($data));
    }

    /**
     * @param mixed $id
     * @param array<string> $data
     * @return bool
     */
    public function update(mixed $id, array $data): bool
    {
        return (bool)$this->getQuery()
            ->where('id', $id)
            ->update($this->getData($data));
    }

    /**
     * @param mixed $id
     * @return bool
     */
    public function destroy(mixed $id): bool
    {
        $result = true;
        $category = $this->getQuery()->where('id', $id)->first();

        DB::beginTransaction();

        try {
            if ($category) {
                $this->getQuery()->where('id', $id)->delete();
                $this->getQuery()->where('parent_id', $id)->update(['parent_id' => $category->parent_id]);
                DB::table('product_to_category')->where('category_id', $id)->delete();
                DB::commit();
            }
        } catch (Throwable $exception) {
            Log::error('Error delete Category', [$exception->getMessage()]);
            DB::rollBack();
            $result = false;
        }

        return $result;
    }

    /**
     * @return array<string>
     */
    public function getTree(): array
    {
        $data = $this->getQuery()
            ->select('id', 'name as label', 'code', 'parent_id as parentId')
            ->selectRaw(
                '(select name from ' . $this->table . ' as c where c.id = ' . $this->table . '.parent_id) as parent'
            )
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
