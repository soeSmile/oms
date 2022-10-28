<?php

declare(strict_types=1);

namespace App\Enum;

/**
 * Enum RoleEnum
 */
enum RoleEnum: int
{
    case Admin = 1;
    case Manager = 2;

    /**
     * @return string
     */
    public function title(): string
    {
        return match ($this) {
            self::Admin => 'Admin',
            self::Manager => 'Manager',
        };
    }
}
