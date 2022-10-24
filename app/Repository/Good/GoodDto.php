<?php

declare(strict_types=1);

namespace App\Repository\Good;

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
            $this->categories = $data['category'];
        }
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
