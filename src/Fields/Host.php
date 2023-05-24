<?php

namespace Hamidrezaniazi\Pecs\Fields;

use Hamidrezaniazi\Pecs\Properties\Percent;
use Hamidrezaniazi\Pecs\Properties\ValueList;
use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-host.html */
class Host extends AbstractEcsField
{
    public function __construct(
        public readonly ?string $architecture = null,
        public readonly ?string $bootId = null,
        public readonly ?Percent $cpuUsage = null,
        public readonly ?int $diskReadBytes = null,
        public readonly ?int $diskWriteBytes = null,
        public readonly ?string $domain = null,
        public readonly ?string $hostname = null,
        public readonly ?string $id = null,
        public readonly ?string $ip = null,
        public readonly ?ValueList $mac = null,
        public readonly ?string $name = null,
        public readonly ?int $networkEgressBytes = null,
        public readonly ?int $networkEgressPackets = null,
        public readonly ?int $networkIngressBytes = null,
        public readonly ?int $networkIngressPackets = null,
        public readonly ?string $pidNsIno = null,
        public readonly ?string $type = null,
        public readonly ?int $uptime = null,
        public readonly ?Geo $geo = null,
        public readonly ?Os $os = null,
        public readonly ?Risk $risk = null,
    ) {
        parent::__construct();
    }

    protected function key(): ?string
    {
        return 'host';
    }

    protected function body(): Collection
    {
        return collect([
            'architecture' => $this->architecture,
            'boot.id' => $this->bootId,
            'cpu.usage' => $this->cpuUsage?->scale(),
            'disk.read.bytes' => $this->diskReadBytes,
            'disk.write.bytes' => $this->diskWriteBytes,
            'domain' => $this->domain,
            'hostname' => $this->hostname,
            'id' => $this->id,
            'ip' => $this->ip,
            'mac' => $this->mac?->toArray(),
            'name' => $this->name,
            'network.egress.bytes' => $this->networkEgressBytes,
            'network.egress.packets' => $this->networkEgressPackets,
            'network.ingress.bytes' => $this->networkIngressBytes,
            'network.ingress.packets' => $this->networkIngressPackets,
            'pid_ns_ino' => $this->pidNsIno,
            'type' => $this->type,
            'uptime' => $this->uptime,
            'geo' => $this->geo?->getBody(),
            'os' => $this->os?->getBody(),
            'risk' => $this->risk?->getBody(),
        ]);
    }
}
