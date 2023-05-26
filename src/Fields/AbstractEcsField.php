<?php

namespace Hamidrezaniazi\Pecs\Fields;

use Hamidrezaniazi\Pecs\EcsFieldsCollection;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

abstract class AbstractEcsField
{
    /** @var Collection<int|string, string|int|bool> */
    protected Collection $log;

    protected array $validEmpty = [0, 0.0, '0', '0.0', false, 'false'];

    public function __construct(public readonly bool $rootable = true)
    {
        $this->log = collect([]);
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
                    return empty($item) && !in_array($item, $this->validEmpty, true);
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
}
