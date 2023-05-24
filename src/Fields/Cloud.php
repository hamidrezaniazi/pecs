<?php

namespace Hamidrezaniazi\Pecs\Fields;

use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-cloud.html */
class Cloud extends AbstractEcsField
{
    public function __construct(
        public readonly ?string $accountId = null,
        public readonly ?string $accountName = null,
        public readonly ?string $availabilityZone = null,
        public readonly ?string $instanceId = null,
        public readonly ?string $instanceName = null,
        public readonly ?string $machineType = null,
        public readonly ?string $projectId = null,
        public readonly ?string $projectName = null,
        public readonly ?string $provider = null,
        public readonly ?string $region = null,
        public readonly ?string $serviceName = null,
        public readonly ?Cloud $origin = null,
        public readonly ?Cloud $target = null,
    ) {
        parent::__construct();
    }

    protected function key(): ?string
    {
        return 'cloud';
    }

    protected function body(): Collection
    {
        return collect([
            'account.id' => $this->accountId,
            'account.name' => $this->accountName,
            'availability_zone' => $this->availabilityZone,
            'instance.id' => $this->instanceId,
            'instance.name' => $this->instanceName,
            'machine.type' => $this->machineType,
            'project.id' => $this->projectId,
            'project.name' => $this->projectName,
            'provider' => $this->provider,
            'region' => $this->region,
            'service.name' => $this->serviceName,
            'origin' => $this->origin?->getBody(),
            'target' => $this->target?->getBody(),
        ]);
    }
}
