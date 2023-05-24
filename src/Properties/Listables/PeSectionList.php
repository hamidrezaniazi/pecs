<?php

namespace Hamidrezaniazi\Pecs\Properties\Listables;

use Hamidrezaniazi\Pecs\Fields\PeSection;
use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-pe.html#field-pe-sections */
class PeSectionList
{
    /** @var Collection<string, PeSection> */
    private Collection $list;

    public function __construct()
    {
        $this->list = new Collection();
    }

    public function toArray(): array
    {
        return $this->list->map(fn (PeSection $item) => $item->toArray())->toArray();
    }

    public function push(PeSection $value): self
    {
        $this->list->push($value);

        return $this;
    }
}
