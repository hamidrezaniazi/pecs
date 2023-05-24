<?php

namespace Hamidrezaniazi\Pecs\Fields;

use Hamidrezaniazi\Pecs\Properties\FaasTriggerType;
use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-faas.html */
class Faas extends AbstractEcsField
{
    public function __construct(
        public readonly ?bool $coldstart = null,
        public readonly ?string $execution = null,
        public readonly ?string $id = null,
        public readonly ?string $name = null,
        public readonly ?string $triggerRequestId = null,
        public readonly ?FaasTriggerType $triggerType = null,
        public readonly ?string $version = null,
    ) {
        parent::__construct();
    }

    protected function key(): ?string
    {
        return 'faas';
    }

    protected function body(): Collection
    {
        return collect([
            'coldstart' => $this->coldstart,
            'execution' => $this->execution,
            'id' => $this->id,
            'name' => $this->name,
            'trigger.request_id' => $this->triggerRequestId,
            'trigger.type' => $this->triggerType?->value,
            'version' => $this->version,
        ]);
    }
}
