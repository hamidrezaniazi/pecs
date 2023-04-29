<?php

namespace Hamidrezaniazi\Pecs\Tests\Unit\Properties;

use Hamidrezaniazi\Pecs\Fields\ElfSegment;
use Hamidrezaniazi\Pecs\Properties\ElfSegmentList;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * @covers \Hamidrezaniazi\Pecs\Properties\ElfSegmentList
 */
class ElfSegmentListTest extends TestCase
{
    public function testItCanCreateList(): void
    {
        $list = new ElfSegmentList();
        $this->assertEmpty($list->toArray());

        $key = 'test_key';
        $sections = 'sample_sections';
        $type = 'sample_type';

        $field = new ElfSegment(
            sections: $sections,
            type: $type,
        );
        $list->put($key, $field);

        $this->assertEquals(
            [
                $key => [
                    'sections' => $sections,
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
        $list = new ElfSegmentList();
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
