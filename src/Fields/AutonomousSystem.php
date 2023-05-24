<?php

namespace Hamidrezaniazi\Pecs\Fields;

use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-as.html */
class AutonomousSystem extends AbstractEcsField
{
    public function __construct(
        public readonly ?int $number = null,
        public readonly ?string $organizationName = null,
    ) {
        parent::__construct(false);
    }

    protected function key(): ?string
    {
        return 'as';
    }

    protected function body(): Collection
    {
        return collect([
            'number' => $this->number,
            'organization.name' => $this->organizationName,
        ]);
    }
}
