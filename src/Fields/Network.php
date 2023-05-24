<?php

namespace Hamidrezaniazi\Pecs\Fields;

use Hamidrezaniazi\Pecs\Properties\NetworkDirection;
use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-network.html */
class Network extends AbstractEcsField
{
    public function __construct(
        public readonly ?string $application = null,
        public readonly ?int $bytes = null,
        public readonly ?string $communityId = null,
        public readonly ?NetworkDirection $direction = null,
        public readonly ?string $forwardedIp = null,
        public readonly ?string $ianaNumber = null,
        public readonly ?Vlan $innerVlan = null,
        public readonly ?Vlan $vlan = null,
        public readonly ?string $name = null,
        public readonly ?int $packets = null,
        public readonly ?string $protocol = null,
        public readonly ?string $transport = null,
        public readonly ?string $type = null,
    ) {
        parent::__construct();
    }

    protected function key(): ?string
    {
        return 'network';
    }

    protected function body(): Collection
    {
        return collect([
            'application' => $this->application,
            'bytes' => $this->bytes,
            'community_id' => $this->communityId,
            'direction' => $this->direction?->value,
            'forwarded_ip' => $this->forwardedIp,
            'iana_number' => $this->ianaNumber,
            'inner.vlan' => $this->innerVlan?->getBody(),
            'vlan' => $this->vlan?->getBody(),
            'name' => $this->name,
            'packets' => $this->packets,
            'protocol' => $this->protocol,
            'transport' => $this->transport,
            'type' => $this->type,
        ]);
    }
}
