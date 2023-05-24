<?php

namespace Hamidrezaniazi\Pecs\Fields;

use Hamidrezaniazi\Pecs\Properties\ValueList;
use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-service.html */
class Service extends AbstractEcsField
{
    public function __construct(
        public readonly ?string $address = null,
        public readonly ?string $environment = null,
        public readonly ?string $ephemeralId = null,
        public readonly ?string $id = null,
        public readonly ?string $name = null,
        public readonly ?string $nodeName = null,
        public readonly ?string $nodeRole = null,
        public readonly ?ValueList $nodeRoles = null,
        public readonly ?string $state = null,
        public readonly ?string $type = null,
        public readonly ?string $version = null,
        public readonly ?Service $origin = null,
        public readonly ?Service $target = null,
    ) {
        parent::__construct();
    }

    protected function key(): ?string
    {
        return 'service';
    }

    protected function body(): Collection
    {
        return collect([
            'address' => $this->address,
            'environment' => $this->environment,
            'ephemeral_id' => $this->ephemeralId,
            'id' => $this->id,
            'name' => $this->name,
            'node.name' => $this->nodeName,
            'node.role' => $this->nodeRole,
            'node.roles' => $this->nodeRoles?->toArray(),
            'state' => $this->state,
            'type' => $this->type,
            'version' => $this->version,
            'origin' => $this->origin?->getBody(),
            'target' => $this->target?->getBody(),
        ]);
    }
}
