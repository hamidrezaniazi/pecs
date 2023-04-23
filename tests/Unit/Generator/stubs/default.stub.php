<?php

namespace Hamidrezaniazi\Pecs\Tests\Unit\Generator;

use Illuminate\Support\Collection;
use NameSpaces\ClassType;
use NameSpaces\ClassTypeWithCase;
use Namespaces\EnumType;
use Namespaces\EnumTypeWithCast;
use Namespaces\RequiredButCast;
use OtherNameSpaces\NewClassTypeWithCase;

/** @link https://www.elastic.co/guide/en/elasticsearch/reference/current/docs-index_.html */
class DefaultClass extends AbstractEcsField
{
    public function __construct(
        public readonly string $simple,
        public readonly array $withName,
        public readonly ClassType $classType,
        public readonly ClassType $duplicateClassType,
        public readonly ClassTypeWithCase $classTypeWithCase,
        public readonly string|int|NewClassTypeWithCase $multipleTypes,
        public readonly EnumType $isEnum,
        public readonly EnumTypeWithCast $isEnumWithCast,
        public readonly RequiredButCast $requiredButCast,
        public readonly ?string $simpleNullable = null,
        public readonly ?string $multiDimension = null,
        public readonly ?string $withDefault = 'default_value',
    ) {
        parent::__construct();
    }

    protected function key(): ?string
    {
        return 'default';
    }

    protected function body(): Collection
    {
        return collect([
            'simple' => $this->simple,
            'simple_nullable' => $this->simpleNullable,
            'different_name' => $this->withName,
            'class_type' => $this->classType,
            'duplicate_class_type' => $this->duplicateClassType,
            'class_type_with_case' => $this->classTypeWithCase->toSomething(),
            'multiple_types' => $this->multipleTypes,
            'multi.dimension' => $this->multiDimension,
            'with_default' => $this->withDefault,
            'is_enum' => $this->isEnum?->value,
            'is_enum_with_cast' => $this->isEnumWithCast->toSomething()?->value,
            'required_but_cast' => $this->requiredButCast->toSomething(),
        ]);
    }
}
