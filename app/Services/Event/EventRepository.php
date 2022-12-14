<?php

declare(strict_types=1);

namespace App\Services\Event;

use App\Services\Event\Contracts\DtoEventContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
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
     * @param array $data
     * @return LengthAwarePaginator
     */
    public function getAll(array $data): LengthAwarePaginator
    {
        $query = $this->getQuery()
            ->select(
                'events.id',
                'events.event',
                'events.user_id as userId',
                'events.ip',
                'events.data',
                'events.date',
                'u.name as name'
            )
            ->leftJoin('users as u', 'u.id', '=', 'events.user_id');

        if (isset($data['event'])) {
            $query->where('events.event', $data['event']);
        }

        if (isset($data['user'])) {
            $query->where('events.user_id', $data['user']);
        }

        if (isset($data['order'])) {
            $map = [
                'id'   => 'events.id',
                'user' => 'events.user_id',
                'date' => 'events.date',
            ];

            foreach ($data['order'] as $key => $item) {
                $query->orderBy($map[$key], $item);
            }
        } else {
            $query->orderBy('events.date', 'desc');
        }

        return $query->paginate(25);
    }

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

    /**
     * @return array
     */
    public function getEvents(): array
    {
        $array = [];
        $data = array_column(EventEnum::cases(), 'value');

        foreach ($data as $key => $item) {
            $array[$key]['name'] = EventEnum::from($item)->title();
            $array[$key]['value'] = $item;
        }

        return $array;
    }
}
