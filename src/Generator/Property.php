<?php

namespace Hamidrezaniazi\Pecs\Generator;

use InvalidArgumentException;

/**
 * @phpstan-type PropertySchema = array{
 *     "types": array<int, string>,
 *     "name"?: string,
 *     "cast"?: string,
 *     "default"?: string,
 *     "extract"?: string
 * }
 */
class Property
{
    /**
     * @param array<int, string> $types
     */
    public function __construct(
        public readonly array $types,
        public readonly string $key,
        public readonly string $name,
        public readonly ?string $cast = null,
        public readonly ?string $default = null,
        public readonly ?string $extract = null,
    ) {
    }

    /**
     * @param PropertySchema $property
     * @param string $name
     * @return Property
     */
    public static function parse(array $property, string $name): Property
    {
        if (empty($property['types'])) {
            throw new InvalidArgumentException('Property types can not be empty.');
        }

        return new Property(
            $property['types'],
            $property['name'] ?? $name,
            $name,
            $property['cast'] ?? null,
            $property['default'] ?? null,
            $property['extract'] ?? null,
        );
    }

    public function isNullable(): bool
    {
        return in_array('nullable', $this->types, true);
    }
}
