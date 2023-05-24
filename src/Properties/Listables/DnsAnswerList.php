<?php

namespace Hamidrezaniazi\Pecs\Properties\Listables;

use Hamidrezaniazi\Pecs\Fields\DnsAnswer;
use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-dns.html#field-dns-answers */
class DnsAnswerList
{
    /** @var Collection<string, DnsAnswer> */
    private Collection $list;

    public function __construct()
    {
        $this->list = new Collection();
    }

    public function toArray(): array
    {
        return $this->list->map(fn (DnsAnswer $item) => $item->toArray())->toArray();
    }

    public function push(DnsAnswer $value): self
    {
        $this->list->push($value);

        return $this;
    }
}
