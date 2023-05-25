<?php

namespace Hamidrezaniazi\Pecs\Properties\Listables;

use Hamidrezaniazi\Pecs\Properties\DnsHeaderFlag;
use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-dns.html#field-dns-header-flags */
class DnsHeaderFlagList
{
    /** @var Collection<int, string> */
    private Collection $list;

    public function __construct()
    {
        $this->list = new Collection();
    }

    public function toArray(): array
    {
        return $this->list->toArray();
    }

    public function push(DnsHeaderFlag $value): self
    {
        $this->list->push($value->value);

        return $this;
    }
}
