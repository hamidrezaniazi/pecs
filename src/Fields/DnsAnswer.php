<?php

namespace Hamidrezaniazi\Pecs\Fields;

use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-dns.html#field-dns-answers */
class DnsAnswer extends AbstractEcsField
{
    public function __construct(
        public readonly string $data,
        public readonly ?string $class = null,
        public readonly ?string $name = null,
        public readonly ?int $ttl = null,
        public readonly ?string $type = null,
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
            'class' => $this->class,
            'data' => $this->data,
            'name' => $this->name,
            'ttl' => $this->ttl,
            'type' => $this->type,
        ]);
    }
}
