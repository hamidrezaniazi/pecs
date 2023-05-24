<?php

namespace Hamidrezaniazi\Pecs\Fields;

use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-dll.html */
class Dll extends AbstractEcsField
{
    public function __construct(
        public readonly ?string $name = null,
        public readonly ?string $path = null,
        public readonly ?CodeSignature $codeSignature = null,
        public readonly ?Hash $hash = null,
        public readonly ?Pe $pe = null,
    ) {
        parent::__construct();
    }

    protected function key(): ?string
    {
        return 'dll';
    }

    protected function body(): Collection
    {
        return collect([
            'name' => $this->name,
            'path' => $this->path,
            'code_signature' => $this->codeSignature?->getBody(),
            'hash' => $this->hash?->getBody(),
            'pe' => $this->pe?->getBody(),
        ]);
    }
}
