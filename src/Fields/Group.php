<?php

namespace Hamidrezaniazi\Pecs\Fields;

use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-group.html */
class Group extends AbstractEcsField
{
    public function __construct(
        public readonly ?string $domain = null,
        public readonly ?string $id = null,
        public readonly ?string $name = null,
    ) {
        parent::__construct();
    }

    protected function key(): ?string
    {
        return 'group';
    }

    protected function body(): Collection
    {
        return collect([
            'domain' => $this->domain,
            'id' => $this->id,
            'name' => $this->name,
        ]);
    }
}
