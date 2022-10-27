<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Services\GoodImageService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * Class RemoveGoodImages
 */
class RemoveGoodImagesJob implements ShouldQueue
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
     * @param GoodImageService $goodImageService
     * @return void
     */
    public function handle(GoodImageService $goodImageService): void
    {
        $goodImageService->destroyImages($this->images);
    }
}
