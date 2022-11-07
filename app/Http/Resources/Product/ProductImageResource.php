<?php

declare(strict_types=1);

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class ProductImageResource
 * @property-read int $id
 * @property-read string $name
 * @property-read string $path
 * @property-read bool $deposit
 * @property-read int $count
 */
class ProductImageResource extends JsonResource
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
            'url'  => '/' . $this->path,
        ];
    }
}
