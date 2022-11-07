<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Services\ProductImageService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * Class RemoveProductImages
 */
class RemoveProductImagesJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * @var int
     */
    public int $timeout = 300;

    /**
     * @var array
     */
    public array $images;

    /**
     * @return void
     */
    public function __construct(array $images)
    {
        $this->images = $images;
    }

    /**
     * @param ProductImageService $productImageService
     * @return void
     */
    public function handle(ProductImageService $productImageService): void
    {
        $productImageService->destroyImages($this->images);
    }
}
