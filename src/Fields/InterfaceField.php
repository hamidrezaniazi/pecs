<?php

namespace Hamidrezaniazi\Pecs\Fields;

use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-interface.html */
class InterfaceField extends AbstractEcsField
{
    public function __construct(
        public readonly ?string $alias = null,
        public readonly ?string $id = null,
        public readonly ?string $name = null,
    ) {
        parent::__construct(false);
    }

    protected function key(): ?string
    {
        return 'interface';
    }

    protected function body(): Collection
    {
        return collect([
            'alias' => $this->alias,
            'id' => $this->id,
            'name' => $this->name,
        ]);
    }
}
