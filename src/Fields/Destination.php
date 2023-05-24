<?php

namespace Hamidrezaniazi\Pecs\Fields;

use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-destination.html#ecs-destination */
class Destination extends AbstractEcsField
{
    public function __construct(
        public readonly ?string $address = null,
        public readonly ?int $bytes = null,
        public readonly ?string $domain = null,
        public readonly ?string $ip = null,
        public readonly ?string $mac = null,
        public readonly ?string $natIp = null,
        public readonly ?int $natPort = null,
        public readonly ?int $packets = null,
        public readonly ?int $port = null,
        public readonly ?string $registeredDomain = null,
        public readonly ?string $subdomain = null,
        public readonly ?string $topLevelDomain = null,
        public readonly ?AutonomousSystem $as = null,
        public readonly ?Geo $geo = null,
        public readonly ?User $user = null,
    ) {
        parent::__construct();
    }

    protected function key(): ?string
    {
        return 'destination';
    }

    protected function body(): Collection
    {
        return collect([
            'address' => $this->address,
            'bytes' => $this->bytes,
            'domain' => $this->domain,
            'ip' => $this->ip,
            'mac' => $this->mac,
            'nat.ip' => $this->natIp,
            'nat.port' => $this->natPort,
            'packets' => $this->packets,
            'port' => $this->port,
            'registered_domain' => $this->registeredDomain,
            'subdomain' => $this->subdomain,
            'top_level_domain' => $this->topLevelDomain,
            'as' => $this->as?->getBody(),
            'geo' => $this->geo?->getBody(),
            'user' => $this->user?->getBody(),
        ]);
    }
}
