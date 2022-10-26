<?php

declare(strict_types=1);

namespace App\Http\Resources\Good;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class GoodImageResource
 * @property-read int $id
 * @property-read string $name
 * @property-read string $path
 * @property-read bool $deposit
 * @property-read int $count
 */
class GoodImageResource extends JsonResource
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
            'url'  => $this->path,
        ];
    }
}
