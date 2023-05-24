<?php

namespace Hamidrezaniazi\Pecs\Fields;

use Hamidrezaniazi\Pecs\Properties\ValueList;
use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-rule.html */
class Rule extends AbstractEcsField
{
    public function __construct(
        public readonly ?ValueList $author = null,
        public readonly ?string $category = null,
        public readonly ?string $description = null,
        public readonly ?string $id = null,
        public readonly ?string $license = null,
        public readonly ?string $name = null,
        public readonly ?string $reference = null,
        public readonly ?string $ruleset = null,
        public readonly ?string $uuid = null,
        public readonly ?string $version = null,
    ) {
        parent::__construct();
    }

    protected function key(): ?string
    {
        return 'rule';
    }

    protected function body(): Collection
    {
        return collect([
            'author' => $this->author?->toArray(),
            'category' => $this->category,
            'description' => $this->description,
            'id' => $this->id,
            'license' => $this->license,
            'name' => $this->name,
            'reference' => $this->reference,
            'ruleset' => $this->ruleset,
            'uuid' => $this->uuid,
            'version' => $this->version,
        ]);
    }
}
