<?php

namespace Hamidrezaniazi\Pecs\Generator;

/**
 * @phpstan-import-type PropertySchema from Property
 * @phpstan-type FieldSchema = array{
 *         "document_link": string,
 *         "class": string,
 *         "key"?: string,
 *         "rootable"?: bool,
 *         "listable"?: bool,
 *         "properties": array<string, PropertySchema>
 * }
 */
class Field
{
    /**
     * @param array<int, Property> $properties
     */
    public function __construct(
        public readonly string $class,
        public readonly array $properties,
        public readonly string $documentLink,
        public readonly ?string $key = null,
        public readonly bool $rootable = false,
        public readonly bool $listable = false,
    ) {
    }

    /**
     * @param FieldSchema $field
     * @return Field
     */
    public static function parse(array $field): self
    {
        return new self(
            $field['class'],
            array_map(
                fn (string $name, array $properties) => Property::parse($properties, $name),
                array_keys($field['properties']),
                $field['properties']
            ),
            $field['document_link'],
            $field['key'] ?? null,
            $field['rootable'] ?? true,
            $field['listable'] ?? false,
        );
    }
}
