<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

use function array_merge;
use function in_array;

class TranslateServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
    }

    /**
     * @return void
     */
    public function boot(): void
    {
        $trans = [];
        $locales = ['en', 'ru'];
        $fileName = ['ru', 'auth'];

        foreach ($locales as $locale) {
            $path = base_path("lang/$locale");
            $files = File::allFiles($path);

            foreach ($files as $file) {
                if (in_array($file->getBasename('.php'), $fileName)) {
                    $trans[$locale][] = trans($file->getBasename('.php'), [], $locale);
                }
            }

            $lang = array_merge(...$trans[$locale]);

            Cache::rememberForever($locale, static function () use ($lang) {
                return $lang;
            });
        }
    }
}
