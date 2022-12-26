<?php

namespace Hamidrezaniazi\Pecs\Tests;

use Hamidrezaniazi\Pecs\EcsFieldsCollection;
use Hamidrezaniazi\Pecs\Fields\AbstractEcsField;
use Illuminate\Support\Collection;

class EcsFieldFactory
{
    public static function create(
        ?string $key,
        array $body = [],
        array $custom = [],
        array $wrapper = []
    ): AbstractEcsField {
        return new class($key, $body, $custom, $wrapper) extends AbstractEcsField {
            public function __construct(
                public readonly ?string $key,
                public readonly array $body,
                public readonly array $custom,
                public readonly array $wrapper,
            ) {
                parent::__construct();
            }

            protected function key(): ?string
            {
                return $this->key;
            }

            protected function body(): Collection
            {
                return collect($this->body);
            }

            protected function custom(): Collection
            {
                return collect($this->custom);
            }

            public function wrapper(): EcsFieldsCollection
            {
                return new EcsFieldsCollection($this->wrapper);
            }
        };
    }
}
