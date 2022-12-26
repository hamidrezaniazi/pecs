<?php

namespace Hamidrezaniazi\Pecs;

use Hamidrezaniazi\Pecs\Fields\AbstractEcsField;
use Hamidrezaniazi\Pecs\Fields\Base;
use Hamidrezaniazi\Pecs\Fields\Log;
use Illuminate\Support\Collection;

/** @extends Collection<int, AbstractEcsField> */
class EcsFieldsCollection extends Collection
{
    protected function getArrayableItems(mixed $items): array
    {
        $items = parent::getArrayableItems($items);

        return array_filter($items, fn($item) => $item instanceof AbstractEcsField);
    }

    public function loadInitialFields(EcsInitialData $data): self
    {
        $this
            ->prepend(
                new Base(
                    timestamp: $data->getTimestamp(),
                    message: $data->message,
                ),
            )
            ->prepend(
                new Log(
                    level: $data->levelName,
                    logger: $data->channel,
                ),
            );

        return $this;
    }

    public function loadWrappers(): self
    {
        $this
            ->reduce(function (?Collection $carry, AbstractEcsField $item) {
                return is_null($carry) ? $item->wrapper() : $carry->merge($item->wrapper());
            })
            ->each(function (AbstractEcsField $item) {
                $this->push($item);
            });

        return $this;
    }

    public function render(): AbstractEcsField
    {
        return $this->reverse()->reduce(function (?AbstractEcsField $carry, AbstractEcsField $item) {
            return is_null($carry) ? $item : $carry->append($item);
        });
    }
}
