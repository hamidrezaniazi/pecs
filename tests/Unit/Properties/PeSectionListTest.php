<?php

namespace Hamidrezaniazi\Pecs\Tests\Unit\Properties;

use Hamidrezaniazi\Pecs\Fields\PeSection;
use Hamidrezaniazi\Pecs\Properties\PeSectionList;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * @covers \Hamidrezaniazi\Pecs\Properties\PeSectionList
 */
class PeSectionListTest extends TestCase
{
    public function testItCanCreateList(): void
    {
        $list = new PeSectionList();
        $this->assertEmpty($list->toArray());

        $key = 'test_key';
        $entropy = 1;
        $name = 'test_name';
        $physicalSize = 100;
        $varEntropy = 2;
        $virtualSize = 3;
        $field = new PeSection(
            entropy: $entropy,
            name: $name,
            physicalSize: $physicalSize,
            varEntropy: $varEntropy,
            virtualSize: $virtualSize,
        );
        $list->put($key, $field);

        $this->assertEquals(
            [
                $key => [
                    'entropy' => $entropy,
                    'name' => $name,
                    'physical_size' => $physicalSize,
                    'var_entropy' => $varEntropy,
                    'virtual_size' => $virtualSize,
                ],
            ],
            $list->toArray()
        );
    }

    /** @dataProvider wrongValueDataProvider */
    public function testItShouldNotAcceptWrongValues(mixed $value): void
    {
        $this->expectError();
        $list = new PeSectionList();
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
