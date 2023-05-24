<?php

namespace Hamidrezaniazi\Pecs\Fields;

use Hamidrezaniazi\Pecs\Properties\ValueList;
use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-user.html */
class User extends AbstractEcsField
{
    public function __construct(
        public readonly ?string $domain = null,
        public readonly ?string $email = null,
        public readonly ?string $fullName = null,
        public readonly ?string $hash = null,
        public readonly ?string $id = null,
        public readonly ?string $name = null,
        public readonly ?ValueList $roles = null,
    ) {
        parent::__construct();
    }

    protected function key(): ?string
    {
        return 'user';
    }

    protected function body(): Collection
    {
        return collect([
            'domain' => $this->domain,
            'email' => $this->email,
            'full_name' => $this->fullName,
            'hash' => $this->hash,
            'id' => $this->id,
            'name' => $this->name,
            'roles' => $this->roles?->toArray(),
        ]);
    }
}
