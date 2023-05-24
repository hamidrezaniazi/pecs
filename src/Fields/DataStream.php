<?php

namespace Hamidrezaniazi\Pecs\Fields;

use Hamidrezaniazi\Pecs\Properties\DataStreamType;
use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-data_stream.html */
class DataStream extends AbstractEcsField
{
    public function __construct(
        public readonly ?string $dataset = null,
        public readonly ?string $namespace = 'default',
        public readonly ?DataStreamType $type = null,
    ) {
        parent::__construct();
    }

    protected function key(): ?string
    {
        return 'data_stream';
    }

    protected function body(): Collection
    {
        return collect([
            'dataset' => $this->dataset,
            'namespace' => $this->namespace,
            'type' => $this->type?->value,
        ]);
    }
}
