<?php

namespace Hamidrezaniazi\Pecs\Properties;

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

    public function put(string $key, ElfSection $value): self
    {
        $this->list->put($key, $value);

        return $this;
    }
}
