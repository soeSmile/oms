<?php

namespace App\Http\Resources\Category;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class CategoryTranslateResource
 * @property-read string $name
 * @property-read int $category_id
 */
class CategoryTranslateResource extends JsonResource
{
    /**
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'   => $this->category_id,
            'name' => $this->name,
        ];
    }
}
