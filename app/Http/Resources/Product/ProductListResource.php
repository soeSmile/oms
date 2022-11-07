<?php

declare(strict_types=1);

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class BrandResource
 * @property-read int $id
 * @property-read string $name
 * @property-read int $brand_id
 * @property-read string $brand
 * @property-read bool $deposit
 * @property-read int $count
 */
class ProductListResource extends JsonResource
{
    /**
     * @param $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id'      => $this->id,
            'name'    => $this->name,
            'brandId' => $this->brand_id,
            'brand'   => $this->brand ?? '',
            'count'   => $this->count,
            'deposit' => $this->deposit ? 'Yes' : 'No'
        ];
    }
}
