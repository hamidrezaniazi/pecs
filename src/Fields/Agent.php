<?php

namespace Hamidrezaniazi\Pecs\Fields;

use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-agent.html */
class Agent extends AbstractEcsField
{
    public function __construct(
        public readonly ?string $buildOriginal = null,
        public readonly ?string $ephemeralId = null,
        public readonly ?string $id = null,
        public readonly ?string $name = null,
        public readonly ?string $type = null,
        public readonly ?string $version = null,
    ) {
        parent::__construct();
    }

    protected function key(): ?string
    {
        return 'agent';
    }

    protected function body(): Collection
    {
        return collect([
            'build' => [
                'original' => $this->buildOriginal,
            ],
            'ephemeral_id' => $this->ephemeralId,
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'version' => $this->version,
        ]);
    }
}
