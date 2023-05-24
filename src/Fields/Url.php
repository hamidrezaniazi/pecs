<?php

namespace Hamidrezaniazi\Pecs\Fields;

use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-url.html */
class Url extends AbstractEcsField
{
    public function __construct(
        public readonly ?string $domain = null,
        public readonly ?string $extension = null,
        public readonly ?string $fragment = null,
        public readonly ?string $full = null,
        public readonly ?string $original = null,
        public readonly ?string $password = null,
        public readonly ?string $path = null,
        public readonly ?int $port = null,
        public readonly ?string $query = null,
        public readonly ?string $registeredDomain = null,
        public readonly ?string $scheme = null,
        public readonly ?string $subdomain = null,
        public readonly ?string $topLevelDomain = null,
        public readonly ?string $username = null,
    ) {
        parent::__construct();
    }

    protected function key(): ?string
    {
        return 'url';
    }

    protected function body(): Collection
    {
        return collect([
            'domain' => $this->domain,
            'extension' => $this->extension,
            'fragment' => $this->fragment,
            'full' => $this->full,
            'original' => $this->original,
            'password' => $this->password,
            'path' => $this->path,
            'port' => $this->port,
            'query' => $this->query,
            'registered_domain' => $this->registeredDomain,
            'scheme' => $this->scheme,
            'subdomain' => $this->subdomain,
            'top_level_domain' => $this->topLevelDomain,
            'username' => $this->username,
        ]);
    }
}
