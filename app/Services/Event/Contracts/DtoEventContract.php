<?php

declare(strict_types=1);

namespace App\Services\Event\Contracts;

use App\Services\Event\EventEnum;

/**
 * Interface DtoEventContract
 */
interface DtoEventContract
{
    /**
     * @var array<string, mixed>
     */
    public const SCHEMA = [
        'event'   => 1,
        'user_id' => 0,
        'ip'      => null,
        'data'    => [],
    ];

    /**
     * @param EventEnum $enum
     * @param array $data
     * @return void
     */
    public function set(EventEnum $enum, array $data): void;

    /**
     * @return array
     */
    public function get(): array;
}
