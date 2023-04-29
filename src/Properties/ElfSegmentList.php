<?php

namespace Hamidrezaniazi\Pecs\Properties;

use Hamidrezaniazi\Pecs\Fields\ElfSegment;
use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-elf.html#field-elf-segments */
class ElfSegmentList
{
    /** @var Collection<string, ElfSegment> */
    private Collection $list;

    public function __construct()
    {
        $this->list = new Collection();
    }

    public function toArray(): array
    {
        return $this->list->map(fn(ElfSegment $item) => $item->toArray())->toArray();
    }

    public function put(string $key, ElfSegment $value): self
    {
        $this->list->put($key, $value);

        return $this;
    }
}
