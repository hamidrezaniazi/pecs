<?php

namespace Hamidrezaniazi\Pecs\Properties;

use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-base.html#field-labels */
class PairList
{
    /** @var Collection<string, string|int|float> */
    private Collection $list;

    public function __construct()
    {
        $this->list = new Collection();
    }

    public function toArray(): array
    {
        return $this->list->toArray();
    }

    public function put(string $key, string|int|float $value): self
    {
        $this->list->put($key, $value);

        return $this;
    }
}
