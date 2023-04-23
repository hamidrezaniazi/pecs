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
        $default = 'default_value';
        $extract = 'value';

        $property = Property::parse([
            'types' => $types,
            'name' => $name,
            'cast' => $cast,
            'default' => $default,
            'extract' => $extract,
        ], $fieldName);

        $this->assertSame($types, $property->types);
        $this->assertSame($name, $property->key);
        $this->assertSame($fieldName, $property->name);
        $this->assertSame($cast, $property->cast);
        $this->assertSame($default, $property->default);
        $this->assertSame($extract, $property->extract);
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

    public function testItCanNotParsePropertySchemaIfDefaultIsNotPresent(): void
    {
        $types = ['string'];
        $fieldName = 'field_name';

        $property = Property::parse([
            'types' => $types,
        ], $fieldName);


        $this->assertSame($types, $property->types);
        $this->assertSame($fieldName, $property->key);
        $this->assertSame($fieldName, $property->name);
        $this->assertNull($property->default);
    }

    public function testItCanNotParsePropertySchemaIfIsEnumIsNotPresent(): void
    {
        $types = ['string'];
        $fieldName = 'field_name';

        $property = Property::parse([
            'types' => $types,
        ], $fieldName);

        $this->assertSame($types, $property->types);
        $this->assertSame($fieldName, $property->key);
        $this->assertSame($fieldName, $property->name);
        $this->assertNull($property->extract);
    }

    public function testItShouldDetectIfItIsNullable(): void
    {
        $types = ['string'];
        $fieldName = 'field_name';

        $property = Property::parse([
            'types' => $types,
        ], $fieldName);

        $this->assertFalse($property->isNullable());

        $types = ['string', 'nullable'];

        $property = Property::parse([
            'types' => $types,
        ], $fieldName);

        $this->assertTrue($property->isNullable());
    }
}
