<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

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
        $this->query->with('name', 'parent');

        if (isset($data['order'])) {
            $this->query->orderBy('id');
        }

        return parent::getAll($data);
    }

    /**
     * @return array
     */
    public function getTree(): array
    {
        $data = $this->getAll(['order' => true]);

        foreach ($data as $item) {
            $item->label = $item->name->name;
        }

        $data = $data->toArray();

        return $this->buildTree($data);
    }

    /**
     * @param array $data
     * @param int $parentId
     * @return array
     */
    private function buildTree(array &$data, int $parentId = 0): array
    {
        $result = [];

        foreach ($data as $item) {
            if ((int)$item['parent_id'] === $parentId) {
                $child = $this->buildTree($data, $item['id']);

                if ($child) {
                    $item['child'] = $child;
                }

                $result[] = $item;

                unset($data[$item['id']]);
            }
        }

        return $result;
    }
}
