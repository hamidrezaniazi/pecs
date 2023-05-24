<?php

namespace Hamidrezaniazi\Pecs\Fields;

use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-ecs.html */
class Ecs extends AbstractEcsField
{
    public function __construct(
        public readonly ?string $version = null,
    ) {
        parent::__construct();
    }

    protected function key(): ?string
    {
        return 'ecs';
    }

    protected function body(): Collection
    {
        return collect([
            'version' => $this->version,
        ]);
    }
}
