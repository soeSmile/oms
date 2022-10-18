<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

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
     * @param array<string> $data
     * @return Collection|LengthAwarePaginator|array|Builder[]
     */
    public function getAll(array $data = []): Collection|LengthAwarePaginator|array
    {
        $this->query->with('parent');


        if (isset($data['order'])) {
            $this->query->orderBy($data['order']);
        }

        if (isset($data['exclude'])) {
            $this->query
                ->where('id', '<>', $data['exclude']);
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
        $data = $this->getAll(['order' => 'id']);

        foreach ($data as $item) {
            $item->label = $item->name;
        }

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
            if ((int)$item['parent_id'] === $parentId) {
                $child = $this->buildTree($data, (int)$item['id']);

                if ($child) {
                    $item['child'] = $child;
                }

                $result[] = $item;

                unset($data[$item['id']]);
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
            'parent_id' => $data['parentId'] ?? null
        ];
    }
}
