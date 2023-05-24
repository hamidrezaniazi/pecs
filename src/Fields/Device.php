<?php

namespace Hamidrezaniazi\Pecs\Fields;

use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-device.html */
class Device extends AbstractEcsField
{
    public function __construct(
        public readonly ?string $id = null,
        public readonly ?string $manufacturer = null,
        public readonly ?string $modelIdentifier = null,
        public readonly ?string $modelName = null,
    ) {
        parent::__construct();
    }

    protected function key(): ?string
    {
        return 'device';
    }

    protected function body(): Collection
    {
        return collect([
            'id' => $this->id,
            'manufacturer' => $this->manufacturer,
            'model.identifier' => $this->modelIdentifier,
            'model.name' => $this->modelName,
        ]);
    }
}
