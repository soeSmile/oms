<?php

declare(strict_types=1);

namespace App\Services\Event;

use App\Services\Event\Contracts\DtoEventContract;

/**
 * Class Event
 */
final class Event
{
    /**
     * @param EventEnum $enum
     * @param array $data
     * @return void
     */
    public static function store(EventEnum $enum, array $data = []): void
    {
        $dto = new ($enum->dto())();
        $repository = new EventRepository();

        if ($dto instanceof DtoEventContract) {
            $dto->set($enum, $data);
            $repository->store($dto);
        }
    }
}