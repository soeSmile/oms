<?php

namespace App\Http\Resources\Category;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class CategoryResource
 * @property-read int $id
 * @property-read object $name
 * @property-read object $parent
 */
class CategoryResource extends JsonResource
{
    /**
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'     => $this->id,
            'name'   => $this->name,
            'parent' => $this->parent ? new CategoryResource($this->parent) : []
        ];
    }
}
