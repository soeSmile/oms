<?php

declare(strict_types=1);

namespace App\Repository\Good;

use function array_unique;

/**
 * Class GoodDto
 */
class GoodDto
{
    /**
     * @var array
     */
    private array $good;

    /**
     * @var array
     */
    private array $categories = [];

    /**
     * @var array
     */
    private array $numbers = [];

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
            $this->categories = array_unique($data['category']);
        }

        if (isset($data['number'])) {
            $this->numbers = array_unique($data['number']);
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
     * @return bool
     */
    public function hasTnved(): bool
    {
        return $this->tnved !== [];
    }

    /**
     * @return bool
     */
    public function hasOe(): bool
    {
        return $this->oe !== [];
    }


    /**
     * @return bool
     */
    public function hasNumber(): bool
    {
        return $this->numbers !== [];
    }

    /**
     * @param int $goodId
     * @return array
     */
    public function numbers(int $goodId): array
    {
        $array = [];

        foreach ($this->numbers as $item) {
            $array[] = ['good_id' => $goodId, 'number' => $item];
        }

        return $array;
    }

    /**
     * @return array
     */
    public function storeData(): array
    {
        return $this->good;
    }

    /**
     * @return bool
     */
    public function hasCategory(): bool
    {
        return $this->categories !== [];
    }

    /**
     * @param int $goodId
     * @return array
     */
    public function categories(int $goodId): array
    {
        $array = [];

        foreach ($this->categories as $item) {
            $array[] = ['good_id' => $goodId, 'category_id' => $item];
        }

        return $array;
    }
}
