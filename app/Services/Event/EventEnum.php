<?php

declare(strict_types=1);

namespace App\Services\Event;

use App\Services\Event\Dto\DefaultDto;
use App\Services\Event\Dto\LoginAttemptDto;
use App\Services\Event\Dto\LoginDto;

/**
 * Enum EventEnum
 */
enum EventEnum: int
{
    case Def = 1;
    case Login = 2;
    case LogOut = 3;
    case LoginAttempt = 4;

    /**
     * @return string
     */
    public function title(): string
    {
        return match ($this) {
            self::Def => 'Default event',
            self::Login => 'User login',
            self::LogOut => 'User logout',
            self::LoginAttempt => 'Login attempt'
        };
    }

    /**
     * @return string
     */
    public function dto(): string
    {
        return match ($this) {
            self::Def, self::LogOut => DefaultDto::class,
            self::LoginAttempt => LoginAttemptDto::class,
            self::Login => LoginDto::class,
        };
    }
}
