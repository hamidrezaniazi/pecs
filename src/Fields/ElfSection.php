<?php

namespace Hamidrezaniazi\Pecs\Fields;

use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-elf.html#field-elf-sections */
class ElfSection extends AbstractEcsField
{
    public function __construct(
        public readonly ?int $chi2 = null,
        public readonly ?int $entropy = null,
        public readonly ?string $flags = null,
        public readonly ?string $name = null,
        public readonly ?string $physicalOffset = null,
        public readonly ?int $physicalSize = null,
        public readonly ?string $type = null,
        public readonly ?int $varEntropy = null,
        public readonly ?int $virtualAddress = null,
        public readonly ?int $virtualSize = null,
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
            'chi2' => $this->chi2,
            'entropy' => $this->entropy,
            'flags' => $this->flags,
            'name' => $this->name,
            'physical_offset' => $this->physicalOffset,
            'physical_size' => $this->physicalSize,
            'type' => $this->type,
            'var_entropy' => $this->varEntropy,
            'virtual_address' => $this->virtualAddress,
            'virtual_size' => $this->virtualSize,
        ]);
    }
}
