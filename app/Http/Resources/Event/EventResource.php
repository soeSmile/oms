<?php

declare(strict_types=1);

namespace App\Http\Resources\Event;

use App\Services\Event\EventEnum;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonException;

/**
 * Class EventResource
 * @property-read int $id
 * @property-read int $event
 * @property-read int $userId
 * @property-read string $name
 * @property-read string $ip
 * @property-read string $date
 * @property-read string $data
 */
class EventResource extends JsonResource
{
    /**
     * @param $request
     * @return array<string, mixed>
     * @throws JsonException
     */
    public function toArray($request): array
    {
        return [
            'id'        => $this->id,
            'event'     => $this->event,
            'eventName' => EventEnum::from($this->event)->title(),
            'userId'    => $this->userId,
            'name'      => $this->name,
            'ip'        => $this->ip,
            'date'      => Carbon::parse($this->date)->format('H:i:s d-m-Y'),
            'data'      => json_decode($this->data, false, 512, JSON_THROW_ON_ERROR),
        ];
    }
}
