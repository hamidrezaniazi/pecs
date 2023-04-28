<?php

namespace Hamidrezaniazi\Pecs\Fields;

use Hamidrezaniazi\Pecs\EcsFieldsCollection;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

abstract class AbstractEcsField
{
    private bool $rootable;

    /** @var Collection<int|string, string|int|bool> */
    protected Collection $log;

    public function __construct(bool $rootable = true)
    {
        $this->log = collect([]);
        $this->rootable = $rootable;
    }

    abstract protected function key(): ?string;

    /** @return Collection<string, mixed> */
    abstract protected function body(): Collection;

    public function append(self $ecsField): self
    {
        if (is_null($ecsField->key())) {
            $next = $ecsField->getBody();
        } else {
            $next = collect([])->put($ecsField->key(), $ecsField->getBody());
        }

        $this->log = $this->log->merge(
            collect(Arr::dot($next->toArray()))
                ->reject(function (mixed $item) {
                    return collect($item)->isEmpty(); //@phpstan-ignore-line
                })
        );

        return $this;
    }

    public function toArray(): array
    {
        return $this->append($this)->log
            ->undot()
            ->toArray();
    }

    /** @return Collection<string, float|int|string|null> */
    protected function getBody(): Collection
    {
        return collect(Arr::dot($this->body()))->merge(Arr::dot($this->custom()));
    }

    /** @return Collection<int|string, mixed> */
    protected function custom(): Collection
    {
        return collect([]);
    }

    public function wrapper(): EcsFieldsCollection
    {
        return new EcsFieldsCollection();
    }

    public function isRootable(): bool
    {
        return $this->rootable;
    }
}
