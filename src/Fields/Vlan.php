<?php

namespace Hamidrezaniazi\Pecs\Fields;

use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-vlan.html */
class Vlan extends AbstractEcsField
{
    public function __construct(
        public readonly ?string $id = null,
        public readonly ?string $name = null,
    ) {
        parent::__construct(false);
    }

    protected function key(): ?string
    {
        return 'vlan';
    }

    protected function body(): Collection
    {
        return collect([
            'id' => $this->id,
            'name' => $this->name,
        ]);
    }
}
