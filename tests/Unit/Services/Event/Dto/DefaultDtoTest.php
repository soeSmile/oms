<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Event\Dto;

use App\Services\Event\Dto\DefaultDto;
use App\Services\Event\EventEnum;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use JsonException;
use Tests\CreatesApplication;

use function array_diff_key;

/**
 * Class DefaultDtoTest
 */
class DefaultDtoTest extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @var DefaultDto
     */
    private DefaultDto $dto;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->dto = new DefaultDto();
        parent::setUp();
    }

    /**
     * @return void
     * @throws JsonException
     */
    public function testDefaultGet(): void
    {
        $array = [];
        $this->dto->set(EventEnum::Def, $array);
        $this->assertEquals([], array_diff_key($this->dto->get(), $this->dto::SCHEMA));

        $this->dto->setData('test', 'eqweqwe');
        $this->assertEquals([], array_diff_key($this->dto->get(), $this->dto::SCHEMA));
    }
}
