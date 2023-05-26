<?php

namespace Hamidrezaniazi\Pecs\Properties\Listables;

use Hamidrezaniazi\Pecs\Fields\ThreatEnrichment;
use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-threat.html */
class ThreatEnrichmentList
{
    /** @var Collection<string, ThreatEnrichment> */
    private Collection $list;

    public function __construct()
    {
        $this->list = new Collection();
    }

    public function toArray(): array
    {
        return $this->list->map(fn (ThreatEnrichment $item) => $item->toArray())->toArray();
    }

    public function push(ThreatEnrichment $value): self
    {
        $this->list->push($value);

        return $this;
    }
}
