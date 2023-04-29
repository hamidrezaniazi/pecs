<?php

namespace Hamidrezaniazi\Pecs\Tests\Unit\Properties;

use Hamidrezaniazi\Pecs\Fields\DnsAnswer;
use Hamidrezaniazi\Pecs\Properties\DnsAnswerList;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * @covers \Hamidrezaniazi\Pecs\Properties\DnsAnswerList
 */
class DnsAnswerListTest extends TestCase
{
    public function testItCanCreateList(): void
    {
        $list = new DnsAnswerList();
        $this->assertEmpty($list->toArray());

        $key = 'test_key';
        $class = 'IN';
        $data = '10.20.10.10';
        $name = 'www.example.com';
        $ttl = 180;
        $type = 'CNAME';
        $field = new DnsAnswer(
            class: $class,
            data: $data,
            name: $name,
            ttl: $ttl,
            type: $type,
        );
        $list->put($key, $field);

        $this->assertEquals(
            [
                $key => [
                    'class' => $class,
                    'data' => $data,
                    'name' => $name,
                    'ttl' => $ttl,
                    'type' => $type,
                ],
            ],
            $list->toArray()
        );
    }

    /** @dataProvider wrongValueDataProvider */
    public function testItShouldNotAcceptWrongValues(mixed $value): void
    {
        $this->expectError();
        $list = new DnsAnswerList();
        $list->put('test_key', $value);
    }

    public function wrongValueDataProvider(): array
    {
        return [
            [null],
            [[1, 2, 3]],
            [new stdClass()],
            ['string' => 'test_value'],
            ['int' => 1],
            ['float' => 1.1],
        ];
    }
}
