<?php

namespace Hamidrezaniazi\Pecs\Fields;

use Carbon\Carbon;
use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-package.html */
class Package extends AbstractEcsField
{
    public function __construct(
        public readonly ?string $architecture = null,
        public readonly ?string $buildVersion = null,
        public readonly ?string $checksum = null,
        public readonly ?string $description = null,
        public readonly ?string $installScope = null,
        public readonly ?Carbon $installed = null,
        public readonly ?string $license = null,
        public readonly ?string $name = null,
        public readonly ?string $path = null,
        public readonly ?int $size = null,
        public readonly ?string $type = null,
        public readonly ?string $version = null,
    ) {
        parent::__construct();
    }

    protected function key(): ?string
    {
        return 'package';
    }

    protected function body(): Collection
    {
        return collect([
            'architecture' => $this->architecture,
            'build_version' => $this->buildVersion,
            'checksum' => $this->checksum,
            'description' => $this->description,
            'install_scope' => $this->installScope,
            'installed' => $this->installed?->toIso8601ZuluString(),
            'license' => $this->license,
            'name' => $this->name,
            'path' => $this->path,
            'size' => $this->size,
            'type' => $this->type,
            'version' => $this->version,
        ]);
    }
}
