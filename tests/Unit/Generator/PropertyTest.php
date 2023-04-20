<?php

namespace Hamidrezaniazi\Pecs\Tests\Unit\Generator;

use Hamidrezaniazi\Pecs\Generator\Property;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Hamidrezaniazi\Pecs\Generator\Property
 */
class PropertyTest extends TestCase
{
    public function testItCanParsePropertySchema(): void
    {
        $types = ['string'];
        $name = 'name';
        $cast = 'string';
        $fieldName = 'field_name';
        $property = Property::parse([
            'types' => $types,
            'name' => $name,
            'cast' => $cast,
        ], $fieldName);

        $this->assertSame($types, $property->types);
        $this->assertSame($name, $property->key);
        $this->assertSame($fieldName, $property->name);
        $this->assertSame($cast, $property->cast);
    }

    public function testItCanParsePropertySchemaWhenNameIsNotPresent(): void
    {
        $types = ['string'];
        $cast = 'string';
        $fieldName = 'field_name';
        $property = Property::parse([
            'types' => $types,
            'cast' => $cast,
        ], $fieldName);

        $this->assertSame($types, $property->types);
        $this->assertSame($fieldName, $property->key);
        $this->assertSame($fieldName, $property->name);
        $this->assertSame($cast, $property->cast);
    }

    public function testItCanParsePropertySchemaWhenCastIsNotPresent(): void
    {
        $types = ['string'];
        $name = 'name';
        $fieldName = 'field_name';
        $property = Property::parse([
            'types' => $types,
            'name' => $name,
        ], $fieldName);

        $this->assertSame($types, $property->types);
        $this->assertSame($name, $property->key);
        $this->assertSame($fieldName, $property->name);
        $this->assertNull($property->cast);
    }

    public function testItCanNotParsePropertySchemaIfTypeIsEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Property types can not be empty.');

       Property::parse([
            'types' => [],
        ], 'field_name');
    }
}
