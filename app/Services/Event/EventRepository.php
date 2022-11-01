<?php

declare(strict_types=1);

namespace App\Services\Event;

use App\Services\Event\Contracts\DtoEventContract;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

/**
 * Class EventRepository
 */
final class EventRepository
{
    /**
     * @var string
     */
    private string $table = 'events';

    /**
     * @param DtoEventContract $dtoEvent
     * @return bool
     */
    public function store(DtoEventContract $dtoEvent): bool
    {
        return $this->getQuery()->insert($dtoEvent->get());
    }

    /**
     * @return Builder
     */
    private function getQuery(): Builder
    {
        return DB::table($this->table);
    }
}
