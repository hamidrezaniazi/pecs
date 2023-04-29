<?php

namespace Hamidrezaniazi\Pecs\Properties;

use Hamidrezaniazi\Pecs\Fields\DnsAnswer;
use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-dns.html#field-dns-answers */
class DnsAnswerList
{
    /** @var Collection<string, PeSection> */
    private Collection $list;

    public function __construct()
    {
        $this->list = new Collection();
    }

    public function toArray(): array
    {
        return $this->list->map(fn(DnsAnswer $item) => $item->toArray())->toArray();
    }

    public function put(string $key, DnsAnswer $value): self
    {
        $this->list->put($key, $value);

        return $this;
    }
}
