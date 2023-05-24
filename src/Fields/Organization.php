<?php

namespace Hamidrezaniazi\Pecs\Fields;

use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-organization.html */
class Organization extends AbstractEcsField
{
    public function __construct(
        public readonly ?string $id = null,
        public readonly ?string $name = null,
    ) {
        parent::__construct();
    }

    protected function key(): ?string
    {
        return 'organization';
    }

    protected function body(): Collection
    {
        return collect([
            'id' => $this->id,
            'name' => $this->name,
        ]);
    }
}
