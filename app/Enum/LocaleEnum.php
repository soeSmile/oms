<?php

declare(strict_types=1);

namespace App\Enum;

/**
 * Enum LocaleEnum
 */
enum LocaleEnum: string
{
    case RU = 'ru';
    case EN = 'en';

    /**
     * @return string
     */
    public function title(): string
    {
        return match ($this) {
            self::RU => 'Русский',
            self::EN => 'English',
        };
    }
}

