<?php

namespace Hamidrezaniazi\Pecs\Properties\Listables;

use Hamidrezaniazi\Pecs\Fields\ElfSection;
use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-elf.html#field-elf-sections */
class ElfSectionList
{
    /** @var Collection<string, ElfSection> */
    private Collection $list;

    public function __construct()
    {
        $this->list = new Collection();
    }

    public function toArray(): array
    {
        return $this->list->map(fn(ElfSection $item) => $item->toArray())->toArray();
    }

    public function push(ElfSection $value): self
    {
        $this->list->push($value);

        return $this;
    }
}
