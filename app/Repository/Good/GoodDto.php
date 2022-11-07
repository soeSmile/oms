<?php

declare(strict_types=1);

namespace App\Repository\Good;

use function array_unique;

/**
 * Class GoodDto
 */
final class GoodDto
{
    /**
     * @var array
     */
    private array $good;

    /**
     * @var array
     */
    private array $category = [];

    /**
     * @var array
     */
    private array $number = [];

    /**
     * @var array
     */
    private array $oe = [];

    /**
     * @var array
     */
    private array $tnved = [];

    /**
     * @var array
     */
    private array $hscode = [];

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->good = [
            'name'         => $data['name'],
            'brand_id'     => $data['brandId'] ?? null,
            'width_box'    => $data['widthBox'] ?? null,
            'height_box'   => $data['heightBox'] ?? null,
            'length_box'   => $data['lengthBox'] ?? null,
            'weight_gross' => $data['weightGross'] ?? null,
            'volume'       => $data['volume'] ?? null,
            'deposit'      => $data['deposit'] ?? false
        ];

        if (isset($data['category'])) {
            $this->category = array_unique($data['category']);
        }

        if (isset($data['number'])) {
            $this->number = array_unique($data['number']);
        }

        if (isset($data['oe'])) {
            $this->oe = array_unique($data['oe']);
        }

        if (isset($data['tnved'])) {
            $this->tnved = array_unique($data['tnved']);
        }

        if (isset($data['hscode'])) {
            $this->hscode = array_unique($data['hscode']);
        }
    }

    /**
     * @return bool
     */
    public function hasHscode(): bool
    {
        return $this->hscode !== [];
    }

    /**
     * @param int $goodId
     * @return array
     */
    public function hscode(int $goodId): array
    {
        return $this->setGoodToItem($goodId, 'hscode');
    }

    /**
     * @return bool
     */
    public function hasTnved(): bool
    {
        return $this->tnved !== [];
    }

    /**
     * @param int $goodId
     * @return array
     */
    public function tnved(int $goodId): array
    {
        return $this->setGoodToItem($goodId, 'tnved');
    }

    /**
     * @return bool
     */
    public function hasOe(): bool
    {
        return $this->oe !== [];
    }

    /**
     * @param int $goodId
     * @return array
     */
    public function oe(int $goodId): array
    {
        return $this->setGoodToItem($goodId, 'oe');
    }

    /**
     * @return bool
     */
    public function hasNumber(): bool
    {
        return $this->number !== [];
    }

    /**
     * @param int $goodId
     * @return array
     */
    public function number(int $goodId): array
    {
        return $this->setGoodToItem($goodId, 'number');
    }


    /**
     * @return bool
     */
    public function hasCategory(): bool
    {
        return $this->category !== [];
    }

    /**
     * @param int $goodId
     * @return array
     */
    public function category(int $goodId): array
    {
        return $this->setGoodToItem($goodId, 'category', '_id');
    }

    /**
     * @return array
     */
    public function storeData(): array
    {
        return $this->good;
    }

    /**
     * @param int $goodId
     * @param string $item
     * @param string|null $prefix
     * @return array
     */
    private function setGoodToItem(int $goodId, string $item, string $prefix = null): array
    {
        $array = [];

        foreach ($this->{$item} as $val) {
            $array[] = ['good_id' => $goodId, $item . $prefix => $val];
        }

        return $array;
    }
}
