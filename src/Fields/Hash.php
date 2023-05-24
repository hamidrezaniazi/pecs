<?php

namespace Hamidrezaniazi\Pecs\Fields;

use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-hash.html */
class Hash extends AbstractEcsField
{
    public function __construct(
        public readonly ?string $md5 = null,
        public readonly ?string $sha1 = null,
        public readonly ?string $sha256 = null,
        public readonly ?string $sha512 = null,
        public readonly ?string $ssdeep = null,
        public readonly ?string $tlsh = null,
    ) {
        parent::__construct(false);
    }

    protected function key(): ?string
    {
        return 'hash';
    }

    protected function body(): Collection
    {
        return collect([
            'md5' => $this->md5,
            'sha1' => $this->sha1,
            'sha256' => $this->sha256,
            'sha512' => $this->sha512,
            'ssdeep' => $this->ssdeep,
            'tlsh' => $this->tlsh,
        ]);
    }
}
