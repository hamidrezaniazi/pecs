<?php

namespace Hamidrezaniazi\Pecs\Tests\Unit\Generator;

use Illuminate\Support\Collection;
use NameSpaces\ClassType;
use NameSpaces\ClassTypeWithCase;
use OtherNameSpaces\NewClassTypeWithCase;

/** @link https://www.elastic.co/guide/en/elasticsearch/reference/current/docs-index_.html */
class DefaultClass extends AbstractEcsField
{
    public function __construct(
        public readonly string $simple,
        public readonly array $withName,
        public readonly ClassType $classType,
        public readonly ClassTypeWithCase $classTypeWithCase,
        public readonly string|int|NewClassTypeWithCase $multipleTypes,
        public readonly ?string $simpleNullable = null,
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
            'class_type_with_case' => $this->classTypeWithCase?->toSomething(),
            'multiple_types' => $this->multipleTypes,
        ]);
    }
}
