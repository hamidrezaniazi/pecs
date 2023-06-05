<?php

namespace Hamidrezaniazi\Pecs\Tests\Unit\Fields;

use Hamidrezaniazi\Pecs\Tests\EcsFieldFactory;
use PHPUnit\Framework\TestCase;

class AbstractFieldTest extends TestCase
{
    /** @dataProvider fieldDataProvider */
    public function testItShouldAppendBodyToWrapper(
        ?string $keyA,
        ?string $keyB,
        array $bodyA,
        array $bodyB,
        array $log
    ): void {
        $fieldA = EcsFieldFactory::create($keyA, $bodyA);
        $fieldB = EcsFieldFactory::create($keyB, $bodyB);

        $this->assertEquals($log, $fieldA->append($fieldB)->toArray());
    }

    /** @dataProvider rejectionDataProvider */
    public function testItCouldRejectEmptyValues(?string $key, array $body, array $result): void
    {
        $field = EcsFieldFactory::create($key, $body);

        $this->assertEquals(
            $result,
            $field->toArray(),
        );
    }

    /** @dataProvider customPropertiesProvider */
    public function testItShouldAppendCustomFieldsToTheBody(
        ?string $key,
        array $body,
        array $custom,
        array $result
    ): void {
        $field = EcsFieldFactory::create($key, $body, $custom);

        $this->assertEquals(
            $result,
            $field->toArray(),
        );
    }

    public function fieldDataProvider(): array
    {
        return [
            [
                null,
                null,
                ['foo' => 'bar'],
                ['buz' => 'fred'],
                ['foo' => 'bar', 'buz' => 'fred'],
            ],
            [
                null,
                'key',
                ['foo' => 'bar'],
                ['buz' => 'fred'],
                ['foo' => 'bar', 'key' => ['buz' => 'fred']],
            ],
            [
                'base',
                'key',
                ['foo' => 'bar'],
                ['buz' => 'fred'],
                ['base' => ['foo' => 'bar'], 'key' => ['buz' => 'fred']],
            ],
            [
                'base',
                'base',
                ['foo' => 'bar', 'buz' => 'fred'],
                ['buz' => 'plug', 'quz' => 'cog'],
                ['base' => ['foo' => 'bar', 'buz' => 'fred', 'quz' => 'cog']],
            ],
            [
                'base',
                null,
                ['foo' => 'bar'],
                ['buz' => 'fred'],
                ['base' => ['foo' => 'bar'], 'buz' => 'fred'],
            ],
        ];
    }

    public function rejectionDataProvider(): array
    {
        return [
            [
                null,
                ['foo' => 'bar', 'buz' => null],
                ['foo' => 'bar'],
            ],
            [
                'key',
                ['foo' => 'bar', 'buz' => null],
                ['key' => ['foo' => 'bar']],
            ],
            [
                null,
                ['foo' => 'bar', 'buz' => []],
                ['foo' => 'bar'],
            ],
            [
                'key',
                ['foo' => 'bar', 'buz' => []],
                ['key' => ['foo' => 'bar']],
            ],
            [
                'key',
                ['foo' => ['bar' => null]],
                [],
            ],
            [
                'key',
                ['foo' => ['bar' => ['buz' => null]]],
                [],
            ],
            [
                null,
                ['foo' => ['bar' => null]],
                [],
            ],
            [
                null,
                ['foo' => ['bar' => collect()]],
                [],
            ],
            [
                null,
                ['foo' => ['bar' => collect()]],
                [],
            ],
            [
                null,
                ['foo' => ['bar' => 0]],
                ['foo' => ['bar' => 0]],
            ],
            [
                null,
                ['foo' => ['bar' => '0']],
                ['foo' => ['bar' => '0']],
            ],
            [
                null,
                ['foo' => ['bar' => 0.0]],
                ['foo' => ['bar' => 0.0]],
            ],
            [
                null,
                ['foo' => ['bar' => '0.0']],
                ['foo' => ['bar' => '0.0']],
            ],
            [
                null,
                ['foo' => ['bar' => false]],
                ['foo' => ['bar' => false]],
            ],
            [
                null,
                ['foo' => ['bar' => 'false']],
                ['foo' => ['bar' => 'false']],
            ],
        ];
    }

    public function customPropertiesProvider(): array
    {
        return [
            [
                'key',
                ['foo' => 'bar'],
                [],
                ['key' => ['foo' => 'bar']],
            ],
            [
                'key',
                ['foo' => 'bar'],
                ['fuz' => 'buz'],
                ['key' => ['foo' => 'bar', 'fuz' => 'buz']],
            ],
            [
                'key',
                ['foo' => 'bar'],
                ['fuz' => 'buz', 'foo' => 'new'],
                ['key' => ['foo' => 'new', 'fuz' => 'buz']],
            ],
            [
                null,
                ['foo' => 'bar'],
                ['fuz' => 'buz', 'foo' => 'new'],
                ['foo' => 'new', 'fuz' => 'buz'],
            ],
        ];
    }
}
