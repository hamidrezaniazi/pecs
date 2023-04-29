<?php

namespace Hamidrezaniazi\Pecs\Tests\Unit\Generator;

use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/elasticsearch/reference/current/docs-listable_.html */
class ListableClass extends AbstractEcsField
{
    public function __construct(
        public readonly string $simple,
    ) {
        parent::__construct();
    }

    protected function key(): ?string
    {
        return 'listable';
    }

    protected function body(): Collection
    {
        return collect([
            'simple' => $this->simple,
        ]);
    }
}
