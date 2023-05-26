<?php

namespace Hamidrezaniazi\Pecs\Properties\Listables;

use Hamidrezaniazi\Pecs\Fields\Process;
use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-process.html */
class ProcessList
{
    /** @var Collection<string, Process> */
    private Collection $list;

    public function __construct()
    {
        $this->list = new Collection();
    }

    public function toArray(): array
    {
        return $this->list->map(fn(Process $item) => $item->toArray())->toArray();
    }

    public function push(Process $value): self
    {
        $this->list->push($value);

        return $this;
    }
}
