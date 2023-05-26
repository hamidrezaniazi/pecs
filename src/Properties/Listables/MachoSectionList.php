<?php

namespace Hamidrezaniazi\Pecs\Properties\Listables;

use Hamidrezaniazi\Pecs\Fields\MachoSection;
use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-macho.html#field-macho-sections */
class MachoSectionList
{
    /** @var Collection<string, MachoSection> */
    private Collection $list;

    public function __construct()
    {
        $this->list = new Collection();
    }

    public function toArray(): array
    {
        return $this->list->map(fn(MachoSection $item) => $item->toArray())->toArray();
    }

    public function push(MachoSection $value): self
    {
        $this->list->push($value);

        return $this;
    }
}
