<?php

namespace Hamidrezaniazi\Pecs\Fields;

use Hamidrezaniazi\Pecs\Properties\ValueList;
use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-related.html */
class Related extends AbstractEcsField
{
    public function __construct(
        public readonly ?ValueList $hash = null,
        public readonly ?ValueList $hosts = null,
        public readonly ?ValueList $ip = null,
        public readonly ?ValueList $user = null,
    ) {
        parent::__construct();
    }

    protected function key(): ?string
    {
        return 'related';
    }

    protected function body(): Collection
    {
        return collect([
            'hash' => $this->hash?->toArray(),
            'hosts' => $this->hosts?->toArray(),
            'ip' => $this->ip?->toArray(),
            'user' => $this->user?->toArray(),
        ]);
    }
}
