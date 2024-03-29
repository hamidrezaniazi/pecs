<?php

namespace Hamidrezaniazi\Pecs\Tests\Unit\Properties;

use Hamidrezaniazi\Pecs\Properties\DnsHeaderFlag;
use Hamidrezaniazi\Pecs\Properties\Listables\DnsHeaderFlagList;
use Hamidrezaniazi\Pecs\Tests\Unit\UnitTestHelper;
use PHPUnit\Framework\TestCase;
use stdClass;
use TypeError;

/**
 * @covers \Hamidrezaniazi\Pecs\Properties\Listables\DnsHeaderFlagList
 */
class DnsHeaderFlagListTest extends TestCase
{
    use UnitTestHelper;

    public function testItCanCreateList(): void
    {
        $list = new DnsHeaderFlagList();
        $this->assertEmpty($list->toArray());

        $flag = $this->random(DnsHeaderFlag::cases());
        $list->push($flag);
        $this->assertEquals([$flag->value], $list->toArray());
    }

    /** @dataProvider wrongValueDataProvider */
    public function testItShouldNotAcceptWrongValues(mixed $value): void
    {
        $this->expectException(TypeError::class);
        $list = new DnsHeaderFlagList();
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
