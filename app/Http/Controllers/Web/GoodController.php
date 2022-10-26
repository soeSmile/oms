<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Class GoodController
 */
final class GoodController
{
    /**
     * @param int $id
     * @param string $file
     * @return BinaryFileResponse
     */
    public function showImage(int $id, string $file): BinaryFileResponse
    {
        $path = storage_path('app/good/' . $id . '/img/' . $file);

        return response()->file($path);
    }
}
