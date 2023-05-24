<?php

namespace Hamidrezaniazi\Pecs\Fields;

use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-elf.html#field-elf-segments */
class ElfSegment extends AbstractEcsField
{
    public function __construct(
        public readonly ?string $sections = null,
        public readonly ?string $type = null,
    ) {
        parent::__construct(false);
    }

    protected function key(): ?string
    {
        return null;
    }

    protected function body(): Collection
    {
        return collect([
            'sections' => $this->sections,
            'type' => $this->type,
        ]);
    }
}
