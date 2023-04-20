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
        public readonly array $with_name,
        public readonly ClassType $class_type,
        public readonly ClassTypeWithCase $class_type_with_case,
        public readonly string|int|NewClassTypeWithCase $multiple_types,
        public readonly ?string $simple_nullable = null,
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
            'simple_nullable' => $this->simple_nullable,
            'different_name' => $this->with_name,
            'class_type' => $this->class_type,
            'class_type_with_case' => $this->class_type_with_case?->toSomething(),
            'multiple_types' => $this->multiple_types,
        ]);
    }
}
