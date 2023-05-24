<?php

namespace Hamidrezaniazi\Pecs\Fields;

use Hamidrezaniazi\Pecs\Properties\PairList;
use Hamidrezaniazi\Pecs\Properties\Percent;
use Hamidrezaniazi\Pecs\Properties\ValueList;
use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-container.html */
class Container extends AbstractEcsField
{
    public function __construct(
        public readonly ?Percent $cpuUsage = null,
        public readonly ?int $diskReadBytes = null,
        public readonly ?int $diskWriteBytes = null,
        public readonly ?string $id = null,
        public readonly ?ValueList $imageHashAll = null,
        public readonly ?string $imageName = null,
        public readonly ?ValueList $imageTag = null,
        public readonly ?PairList $labels = null,
        public readonly ?Percent $memoryUsage = null,
        public readonly ?string $name = null,
        public readonly ?int $networkEgressBytes = null,
        public readonly ?int $networkIngressBytes = null,
        public readonly ?string $runtime = null,
    ) {
        parent::__construct();
    }

    protected function key(): ?string
    {
        return 'container';
    }

    protected function body(): Collection
    {
        return collect([
            'cpu.usage' => $this->cpuUsage?->scale(),
            'disk.read.bytes' => $this->diskReadBytes,
            'disk.write.bytes' => $this->diskWriteBytes,
            'id' => $this->id,
            'image.hash.all' => $this->imageHashAll?->toArray(),
            'image.name' => $this->imageName,
            'image.tag' => $this->imageTag?->toArray(),
            'labels' => $this->labels?->toArray(),
            'memory.usage' => $this->memoryUsage?->scale(),
            'name' => $this->name,
            'network.egress.bytes' => $this->networkEgressBytes,
            'network.ingress.bytes' => $this->networkIngressBytes,
            'runtime' => $this->runtime,
        ]);
    }
}
