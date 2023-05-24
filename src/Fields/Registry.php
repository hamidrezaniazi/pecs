<?php

namespace Hamidrezaniazi\Pecs\Fields;

use Hamidrezaniazi\Pecs\Properties\ValueList;
use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-registry.html */
class Registry extends AbstractEcsField
{
    public function __construct(
        public readonly ?string $dataBytes = null,
        public readonly ?ValueList $dataStrings = null,
        public readonly ?string $dataType = null,
        public readonly ?string $hive = null,
        public readonly ?string $key = null,
        public readonly ?string $path = null,
        public readonly ?string $value = null,
    ) {
        parent::__construct();
    }

    protected function key(): ?string
    {
        return 'registry';
    }

    protected function body(): Collection
    {
        return collect([
            'data.bytes' => $this->dataBytes,
            'data.strings' => $this->dataStrings?->toArray(),
            'data.type' => $this->dataType,
            'hive' => $this->hive,
            'key' => $this->key,
            'path' => $this->path,
            'value' => $this->value,
        ]);
    }
}
