<?php

namespace Hamidrezaniazi\Pecs\Monolog;

use Hamidrezaniazi\Pecs\LogRecord;
use Hamidrezaniazi\Pecs\EcsFieldsCollection;
use Monolog\Formatter\NormalizerFormatter;
use Monolog\LogRecord as MonologRecord;

class EcsFormatter extends NormalizerFormatter
{
    public function format(MonologRecord $record): string
    {
        $log = $this
            ->prepare($record)
            ->render()
            ->toArray();

        return $this->toJson($log) . PHP_EOL;
    }

    protected function prepare(MonologRecord $record): EcsFieldsCollection
    {
        $record = LogRecord::parse($record->toArray());

        return (new EcsFieldsCollection($record->context))
            ->loadInitialFields($record)
            ->loadWrappers();
    }
}
