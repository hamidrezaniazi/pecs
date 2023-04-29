<?php

namespace Hamidrezaniazi\Pecs\Tests\Unit\Generator;

use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/elasticsearch/reference/current/docs-nested_.html */
class NestedClass extends AbstractEcsField
{
    public function __construct(
        public readonly string $simple,
    ) {
        parent::__construct(false);
    }

    protected function key(): ?string
    {
        return 'nested';
    }

    protected function body(): Collection
    {
        return collect([
            'simple' => $this->simple,
        ]);
    }
}
