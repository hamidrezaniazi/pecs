<?php

namespace Hamidrezaniazi\Pecs\Fields;

use Hamidrezaniazi\Pecs\Properties\PairList;
use Hamidrezaniazi\Pecs\Properties\ValueList;
use Carbon\Carbon;
use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-base.html */
class Base extends AbstractEcsField
{
    public function __construct(
        public readonly ?Carbon $timestamp = null,
        public readonly ?PairList $labels = null,
        public readonly ?string $message = null,
        public readonly ?ValueList $tags = null,
    ) {
        parent::__construct();
    }

    protected function key(): ?string
    {
        return null;
    }

    protected function body(): Collection
    {
        return collect([
            '@timestamp' => $this->timestamp?->toIso8601ZuluString(),
            'labels' => $this->labels?->toArray(),
            'message' => $this->message,
            'tags' => $this->tags?->toArray(),
        ]);
    }
}
