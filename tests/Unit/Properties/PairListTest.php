<?php

namespace Hamidrezaniazi\Pecs\Tests\Unit\Properties;

use Hamidrezaniazi\Pecs\Properties\PairList;
use Hamidrezaniazi\Pecs\Tests\TestCase;
use stdClass;
use TypeError;

/**
 * @covers \Hamidrezaniazi\Pecs\Properties\PairList
 */
class PairListTest extends TestCase
{
    /** @dataProvider valueDataProvider */
    public function testItCanCreateList(string $key, string|int|float $value): void
    {
        $list = new PairList();
        $this->assertEmpty($list->toArray());

        $list->put($key, $value);
        $this->assertEquals([$key => $value], $list->toArray());
    }

    /** @dataProvider wrongValueDataProvider */
    public function testItShouldNotAcceptWrongValues(mixed $key, mixed $value): void
    {
        $this->expectException(TypeError::class);
        $list = new PairList();
        $list->put($key, $value);
    }

    public function valueDataProvider(): array
    {
        return [
            'string' => ['key', 'test_value'],
            'int' => ['key', 1],
            'float' => ['key', 1.1],
        ];
    }

    public function wrongValueDataProvider(): array
    {
        return [
            [null, 'value'],
            ['key', null],
            ['key', [1, 2, 3]],
            ['key', new stdClass()],
        ];
    }
}
