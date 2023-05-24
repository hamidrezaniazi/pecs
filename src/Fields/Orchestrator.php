<?php

namespace Hamidrezaniazi\Pecs\Fields;

use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-orchestrator.html */
class Orchestrator extends AbstractEcsField
{
    public function __construct(
        public readonly ?string $apiVersion = null,
        public readonly ?string $clusterId = null,
        public readonly ?string $clusterName = null,
        public readonly ?string $clusterUrl = null,
        public readonly ?string $clusterVersion = null,
        public readonly ?string $namespace = null,
        public readonly ?string $organization = null,
        public readonly ?string $resourceId = null,
        public readonly ?string $resourceIp = null,
        public readonly ?string $resourceName = null,
        public readonly ?string $resourceParentType = null,
        public readonly ?string $resourceType = null,
        public readonly ?string $type = null,
    ) {
        parent::__construct();
    }

    protected function key(): ?string
    {
        return 'orchestrator';
    }

    protected function body(): Collection
    {
        return collect([
            'api_version' => $this->apiVersion,
            'cluster.id' => $this->clusterId,
            'cluster.name' => $this->clusterName,
            'cluster.url' => $this->clusterUrl,
            'cluster.version' => $this->clusterVersion,
            'namespace' => $this->namespace,
            'organization' => $this->organization,
            'resource.id' => $this->resourceId,
            'resource.ip' => $this->resourceIp,
            'resource.name' => $this->resourceName,
            'resource.parent.type' => $this->resourceParentType,
            'resource.type' => $this->resourceType,
            'type' => $this->type,
        ]);
    }
}
