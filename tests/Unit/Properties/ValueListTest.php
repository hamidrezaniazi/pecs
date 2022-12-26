<?php

namespace Hamidrezaniazi\Pecs\Tests\Unit\Properties;

use Hamidrezaniazi\Pecs\Properties\ValueList;
use PHPUnit\Framework\TestCase;
use stdClass;

class ValueListTest extends TestCase
{
    /** @dataProvider valueDataProvider */
    public function testItCanCreateList(string|int|float $value): void
    {
        $list = new ValueList();
        $this->assertEmpty($list->toArray());

        $list->push($value);
        $this->assertEquals([$value], $list->toArray());
    }

    /** @dataProvider wrongValueDataProvider */
    public function testItShouldNotAcceptWrongValues(mixed $value): void
    {
        $this->expectError();
        $list = new ValueList();
        $list->push($value);
    }

    public function valueDataProvider(): array
    {
        return [
            ['string' => 'test_value'],
            ['int' => 1],
            ['float' => 1.1],
        ];
    }

    public function wrongValueDataProvider(): array
    {
        return [
            [null],
            [[1, 2, 3]],
            [new stdClass()],
        ];
    }
}
