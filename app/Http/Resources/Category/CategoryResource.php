<?php

namespace App\Http\Resources\Category;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class CategoryResource
 * @property-read int $id
 * @property-read string $name
 * @property-read string $parent
 * @property-read string $parent_id
 * @property-read int $count
 */
class CategoryResource extends JsonResource
{
    /**
     * @param $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id'       => $this->id,
            'name'     => $this->name,
            'parent'   => $this->parent,
            'parentId' => $this->parent_id,
            'count'    => $this->count
        ];
    }
}
