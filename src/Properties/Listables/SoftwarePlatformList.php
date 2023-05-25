<?php

namespace Hamidrezaniazi\Pecs\Properties\Listables;

use Hamidrezaniazi\Pecs\Properties\SoftwarePlatform;
use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-threat.html#field-threat-software-platforms */
class SoftwarePlatformList
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

    public function push(SoftwarePlatform $value): self
    {
        $this->list->push($value->value);

        return $this;
    }
}
