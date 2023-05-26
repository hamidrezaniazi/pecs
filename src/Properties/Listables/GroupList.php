<?php

namespace Hamidrezaniazi\Pecs\Properties\Listables;

use Hamidrezaniazi\Pecs\Fields\Group;
use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-group.html */
class GroupList
{
    /** @var Collection<string, Group> */
    private Collection $list;

    public function __construct()
    {
        $this->list = new Collection();
    }

    public function toArray(): array
    {
        return $this->list->map(fn(Group $item) => $item->toArray())->toArray();
    }

    public function push(Group $value): self
    {
        $this->list->push($value);

        return $this;
    }
}
