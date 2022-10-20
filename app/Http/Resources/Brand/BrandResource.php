<?php

declare(strict_types=1);

namespace App\Http\Resources\Brand;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class BrandResource
 * @property-read int $id
 * @property-read string $name
 */
class BrandResource extends JsonResource
{
    /**
     * @param $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id'   => $this->id,
            'name' => $this->name,
        ];
    }
}
