<?php

namespace Hamidrezaniazi\Pecs\Fields;

use Hamidrezaniazi\Pecs\Properties\ValueList;
use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-observer.html */
class Observer extends AbstractEcsField
{
    public function __construct(
        public readonly ?string $egressZone = null,
        public readonly ?InterfaceField $egressInterface = null,
        public readonly ?Vlan $egressVlan = null,
        public readonly ?string $hostname = null,
        public readonly ?string $ingressZone = null,
        public readonly ?InterfaceField $ingressInterface = null,
        public readonly ?Vlan $ingressVlan = null,
        public readonly ?string $ip = null,
        public readonly ?ValueList $mac = null,
        public readonly ?string $name = null,
        public readonly ?string $product = null,
        public readonly ?string $serialNumber = null,
        public readonly ?string $type = null,
        public readonly ?string $vendor = null,
        public readonly ?string $version = null,
        public readonly ?Geo $geo = null,
        public readonly ?Os $os = null,
    ) {
        parent::__construct();
    }

    protected function key(): ?string
    {
        return 'observer';
    }

    protected function body(): Collection
    {
        return collect([
            'egress.zone' => $this->egressZone,
            'egress.interface' => $this->egressInterface?->getBody(),
            'egress.vlan' => $this->egressVlan?->getBody(),
            'hostname' => $this->hostname,
            'ingress.zone' => $this->ingressZone,
            'ingress.interface' => $this->ingressInterface?->getBody(),
            'ingress.vlan' => $this->ingressVlan?->getBody(),
            'ip' => $this->ip,
            'mac' => $this->mac?->toArray(),
            'name' => $this->name,
            'product' => $this->product,
            'serial_number' => $this->serialNumber,
            'type' => $this->type,
            'vendor' => $this->vendor,
            'version' => $this->version,
            'geo' => $this->geo?->getBody(),
            'os' => $this->os?->getBody(),
        ]);
    }
}
