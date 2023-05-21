<?php

namespace Hamidrezaniazi\Pecs\Tests\Unit\Properties;

use Hamidrezaniazi\Pecs\Properties\SoftwarePlatform;
use Hamidrezaniazi\Pecs\Properties\SoftwarePlatformList;
use Hamidrezaniazi\Pecs\Tests\Unit\UnitTestHelper;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * @covers \Hamidrezaniazi\Pecs\Properties\SoftwarePlatformList
 */
class SoftwarePlatformListTest extends TestCase
{
    use UnitTestHelper;

    public function testItCanCreateList(): void
    {
        $list = new SoftwarePlatformList();
        $this->assertEmpty($list->toArray());

        $platform = $this->random(SoftwarePlatform::cases());
        $list->push($platform);
        $this->assertEquals([$platform->value], $list->toArray());
    }

    /** @dataProvider wrongValueDataProvider */
    public function testItShouldNotAcceptWrongValues(mixed $value): void
    {
        $this->expectError();
        $list = new SoftwarePlatformList();
        $list->push($value);
    }

    public function wrongValueDataProvider(): array
    {
        return [
            [null],
            [[1, 2, 3]],
            [new stdClass()],
            [1],
            [1.1],
            ['string'],
        ];
    }
}
