<?php

namespace Hamidrezaniazi\Pecs\Fields;

use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-tracing.html */
class Tracing extends AbstractEcsField
{
    public function __construct(
        public readonly ?string $spanId = null,
        public readonly ?string $traceId = null,
        public readonly ?string $transactionId = null,
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
            'span.id' => $this->spanId,
            'trace.id' => $this->traceId,
            'transaction.id' => $this->transactionId,
        ]);
    }
}
