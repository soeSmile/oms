<?php

declare(strict_types=1);

namespace App\Services\Event\Dto;

use App\Services\Event\Contracts\DtoEventContract;
use App\Services\Event\EventEnum;
use JsonException;

use function array_key_exists;

abstract class AbstractDto implements DtoEventContract
{
    /**
     * @var array<string, string>
     */
    protected array $map = [];

    /**
     * @var array
     */
    private array $data = [];

    /**
     * @return array
     */
    public function get(): array
    {
        foreach (self::SCHEMA as $key => $item) {
            if (!array_key_exists($key, $this->data)) {
                $this->data[$key] = $item;
            }
        }

        return $this->data;
    }

    /**
     * @param EventEnum $enum
     * @param array $data
     * @return void
     * @throws JsonException
     */
    public function set(EventEnum $enum, array $data): void
    {
        $array = [];

        foreach ($data as $key => $item) {
            if (array_key_exists($key, $this->map)) {
                $array[$this->map[$key]] = $item;
            }
        }

        $this->data['data'] = json_encode($array, JSON_THROW_ON_ERROR);
        $this->data['event'] = $enum->value;
        $this->data['user_id'] = auth()->id() ?? 0;
        $this->data['ip'] = getIP();
    }

    /**
     * @param string $key
     * @param mixed|null $value
     * @return void
     */
    public function setData(string $key, mixed $value = null): void
    {
        if ($value && array_key_exists($key, self::SCHEMA)) {
            $this->data[$key] = $value;
        }
    }
}
