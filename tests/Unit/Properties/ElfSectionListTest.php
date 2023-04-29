<?php

namespace Hamidrezaniazi\Pecs\Tests\Unit\Properties;

use Hamidrezaniazi\Pecs\Fields\ElfSection;
use Hamidrezaniazi\Pecs\Properties\ElfSectionList;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * @covers \Hamidrezaniazi\Pecs\Properties\ElfSectionList
 */
class ElfSectionListTest extends TestCase
{
    public function testItCanCreateList(): void
    {
        $list = new ElfSectionList();
        $this->assertEmpty($list->toArray());

        $key = 'test_key';
        $chi2 = 1;
        $entropy = 2;
        $flags = 'sample_flag';
        $name = 'sample_name';
        $physicalOffset = 'sample_physical_offset';
        $physicalSize = 1500;
        $type = 'sample_type';
        $varEntropy = 3;
        $virtualAddress = 2143245;
        $virtualSize = 2500;

        $field = new ElfSection(
            chi2: $chi2,
            entropy: $entropy,
            flags: $flags,
            name: $name,
            physicalOffset: $physicalOffset,
            physicalSize: $physicalSize,
            type: $type,
            varEntropy: $varEntropy,
            virtualAddress: $virtualAddress,
            virtualSize: $virtualSize
        );
        $list->put($key, $field);

        $this->assertEquals(
            [
                $key => [
                    'chi2' => $chi2,
                    'entropy' => $entropy,
                    'flags' => $flags,
                    'name' => $name,
                    'physical_offset' => $physicalOffset,
                    'physical_size' => $physicalSize,
                    'type' => $type,
                    'var_entropy' => $varEntropy,
                    'virtual_address' => $virtualAddress,
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
        $list = new ElfSectionList();
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
