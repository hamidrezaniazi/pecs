<?php

namespace Hamidrezaniazi\Pecs\Properties\Listables;

use Hamidrezaniazi\Pecs\Properties\FileAttribute;
use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-file.html#field-file-attributes */
class FileAttributeList
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

    public function push(FileAttribute $value): self
    {
        $this->list->push($value->value);

        return $this;
    }
}
