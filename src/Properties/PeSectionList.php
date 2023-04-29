<?php

namespace Hamidrezaniazi\Pecs\Properties;

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
        return $this->list->map(fn(PeSection $item) => $item->toArray())->toArray();
    }

    public function put(string $key, PeSection $value): self
    {
        $this->list->put($key, $value);

        return $this;
    }
}
