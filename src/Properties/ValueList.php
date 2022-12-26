<?php

namespace Hamidrezaniazi\Pecs\Properties;

use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-base.html#field-tags */
class ValueList
{
    /** @var Collection<int, string|int|float> */
    private Collection $list;

    public function __construct()
    {
        $this->list = new Collection();
    }

    public function toArray(): array
    {
        return $this->list->toArray();
    }

    public function push(string|int|float $value): self
    {
        $this->list->push($value);

        return $this;
    }
}
