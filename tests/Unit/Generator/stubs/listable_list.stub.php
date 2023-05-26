<?php

namespace Hamidrezaniazi\Pecs\Tests\Unit\Generator\Properties\Listables;

use Hamidrezaniazi\Pecs\Tests\Unit\Generator\ListableClass;
use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/elasticsearch/reference/current/docs-listable_.html */
class ListableClassList
{
    /** @var Collection<string, ListableClass> */
    private Collection $list;

    public function __construct()
    {
        $this->list = new Collection();
    }

    public function toArray(): array
    {
        return $this->list->map(fn (ListableClass $item) => $item->toArray())->toArray();
    }

    public function push(ListableClass $value): self
    {
        $this->list->push($value);

        return $this;
    }
}
