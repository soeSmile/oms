<?php

declare(strict_types=1);

namespace App\Services;

use App\Repository\GoodImageRepository;

/**
 * Class GoodImageService
 */
final class GoodImageService
{
    /**
     * @param GoodImageRepository $goodImageRepository
     */
    public function __construct(private readonly GoodImageRepository $goodImageRepository)
    {
    }

    /**
     * @param int $goodId
     * @param mixed|null $file
     * @return array
     */
    public function uploadImage(int $goodId, mixed $file = null): array
    {
        $result = [];

        if ($file) {
            $path = $file->store('good/' . $goodId . '/img');

            if ($path) {
                $name = $file->getClientOriginalName();

                $result['goodId'] = $goodId;
                $result['name'] = $name;
                $result['url'] = $path;

                $this->goodImageRepository->store($result);
            }
        }

        return $result;
    }
}
