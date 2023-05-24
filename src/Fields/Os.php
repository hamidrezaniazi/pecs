<?php

namespace Hamidrezaniazi\Pecs\Fields;

use Hamidrezaniazi\Pecs\Properties\OsType;
use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-os.html */
class Os extends AbstractEcsField
{
    public function __construct(
        public readonly ?string $family = null,
        public readonly ?string $full = null,
        public readonly ?string $kernel = null,
        public readonly ?string $name = null,
        public readonly ?string $platform = null,
        public readonly ?OsType $type = null,
        public readonly ?string $version = null,
    ) {
        parent::__construct(false);
    }

    protected function key(): ?string
    {
        return 'os';
    }

    protected function body(): Collection
    {
        return collect([
            'family' => $this->family,
            'full' => $this->full,
            'kernel' => $this->kernel,
            'name' => $this->name,
            'platform' => $this->platform,
            'type' => $this->type?->value,
            'version' => $this->version,
        ]);
    }
}
