<?php

declare(strict_types=1);

namespace App\Services\Event\Dto;

/**
 * Class LoginAttemptDto
 */
final class LoginAttemptDto extends AbstractDto
{
    /**
     * @var array<string, string>
     */
    protected array $map = [
        'email' => 'Email',
    ];
}
