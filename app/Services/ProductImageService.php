<?php

declare(strict_types=1);

namespace App\Services;

use App\Repository\ProductImageRepository;
use Illuminate\Support\Facades\Storage;

/**
 * Class ProductImageService
 */
final class ProductImageService
{
    /**
     * @param ProductImageRepository $productImageRepository
     */
    public function __construct(private readonly ProductImageRepository $productImageRepository)
    {
    }

    /**
     * @param int $productId
     * @param mixed|null $file
     * @return array
     */
    public function uploadImage(int $productId, mixed $file = null): array
    {
        $result = [];

        if ($file) {
            $path = $file->store('product/' . $productId . '/img');

            if ($path) {
                $name = $file->getClientOriginalName();

                $result['productId'] = $productId;
                $result['name'] = $name;
                $result['url'] = $path;

                $result['id'] = $this->productImageRepository->store($result);
            }
        }

        return $result;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function destroy(int $id): bool
    {
        $result = true;
        $item = $this->productImageRepository->show($id);

        if ($item && Storage::delete($item->path)) {
            $result = $this->productImageRepository->destroy($id);
        }

        return $result;
    }

    /**
     * @param array $images
     * @return void
     */
    public function destroyImages(array $images): void
    {
        foreach ($images as $image) {
            $path = is_array($image) ? $image['path'] : $image->path;
            Storage::delete($path);
        }
    }
}
