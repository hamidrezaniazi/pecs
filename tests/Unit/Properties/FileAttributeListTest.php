<?php

namespace Hamidrezaniazi\Pecs\Tests\Unit\Properties;

use Hamidrezaniazi\Pecs\Properties\FileAttribute;
use Hamidrezaniazi\Pecs\Properties\Listables\FileAttributeList;
use Hamidrezaniazi\Pecs\Tests\Unit\UnitTestHelper;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * @covers \Hamidrezaniazi\Pecs\Properties\Listables\FileAttributeList
 */
class FileAttributeListTest extends TestCase
{
    use UnitTestHelper;

    public function testItCanCreateList(): void
    {
        $list = new FileAttributeList();
        $this->assertEmpty($list->toArray());

        $attribute = $this->random(FileAttribute::cases());
        $list->push($attribute);
        $this->assertEquals([$attribute->value], $list->toArray());
    }

    /** @dataProvider wrongValueDataProvider */
    public function testItShouldNotAcceptWrongValues(mixed $value): void
    {
        $this->expectError();
        $list = new FileAttributeList();
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
