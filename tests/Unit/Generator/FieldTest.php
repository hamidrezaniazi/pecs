<?php

namespace Hamidrezaniazi\Pecs\Tests\Unit\Generator;

use Exception;
use Hamidrezaniazi\Pecs\Bin\Generator\Field;
use Hamidrezaniazi\Pecs\Bin\Generator\Property;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Hamidrezaniazi\Pecs\Bin\Generator\Field
 */
class FieldTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testItCanParseFieldSchema(): void
    {
        $link = 'https://www.elastic.co/guide/en/elasticsearch/reference/current/field-caps.html';
        $class = 'FieldCaps';
        $key = 'field_caps';
        $first = [
            'fields' => [
                'types' => ['array'],
                'cast' => 'array',
            ]
        ];
        $second = [
            'indices' => [
                'types' => ['array'],
                'cast' => 'array',
            ]
        ];
        $rootable = (bool)random_int(0, 1);
        $listable = (bool)random_int(0, 1);

        $field = Field::parse([
            'document_link' => $link,
            'class' => $class,
            'key' => $key,
            'rootable' => $rootable,
            'listable' => $listable,
            'properties' => [
                ...$first,
                ...$second,
            ],
        ]);

        $this->assertSame($link, $field->documentLink);
        $this->assertSame($class, $field->class);
        $this->assertSame($key, $field->key);
        $this->assertEquals([
            Property::parse($first['fields'], 'fields'),
            Property::parse($second['indices'], 'indices'),
        ], $field->properties);
        $this->assertSame($rootable, $field->rootable);
        $this->assertSame($listable, $field->listable);
    }

    public function testItCanParseFieldSchemaWhenKeyIsNotPresent(): void
    {
        $link = 'https://www.elastic.co/guide/en/elasticsearch/reference/current/field-caps.html';
        $class = 'FieldCaps';

        $field = Field::parse([
            'document_link' => $link,
            'class' => $class,
            'properties' => [],
        ]);

        $this->assertSame($link, $field->documentLink);
        $this->assertSame($class, $field->class);
        $this->assertNull($field->key);
    }

    public function testItCanParseFieldSchemaWhenRootableIsNotPresent(): void
    {
        $link = 'https://www.elastic.co/guide/en/elasticsearch/reference/current/field-caps.html';
        $class = 'FieldCaps';

        $field = Field::parse([
            'document_link' => $link,
            'class' => $class,
            'properties' => [],
        ]);

        $this->assertSame($link, $field->documentLink);
        $this->assertSame($class, $field->class);
        $this->assertTrue($field->rootable);
    }

    public function testItCanParseFieldSchemaWhenListableIsNotPresent(): void
    {
        $link = 'https://www.elastic.co/guide/en/elasticsearch/reference/current/field-caps.html';
        $class = 'FieldCaps';

        $field = Field::parse([
            'document_link' => $link,
            'class' => $class,
            'properties' => [],
        ]);

        $this->assertSame($link, $field->documentLink);
        $this->assertSame($class, $field->class);
        $this->assertFalse($field->listable);
    }
}
