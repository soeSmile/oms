<?php

declare(strict_types=1);

namespace App\Services\Event\Dto;

/**
 * Class LoginDto
 */
final class LoginDto extends AbstractDto
{
    /**
     * @var array<string, string>
     */
    protected array $map = [
        'email' => 'Email'
    ];
}
