<?php

namespace Hamidrezaniazi\Pecs\Fields;

use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-macho.html#field-macho-sections */
class MachoSection extends AbstractEcsField
{
    public function __construct(
        public readonly ?int $entropy = null,
        public readonly ?string $name = null,
        public readonly ?int $physicalSize = null,
        public readonly ?int $varEntropy = null,
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
            'entropy' => $this->entropy,
            'name' => $this->name,
            'physical_size' => $this->physicalSize,
            'var_entropy' => $this->varEntropy,
            'virtual_size' => $this->virtualSize,
        ]);
    }
}
