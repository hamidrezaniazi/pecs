<?php

namespace Hamidrezaniazi\Pecs\Monolog;

use Hamidrezaniazi\Pecs\EcsFieldsCollection;
use Monolog\Formatter\NormalizerFormatter;

/** @phpstan-import-type LogRecordSchema from LogRecord */
class EcsFormatter extends NormalizerFormatter
{
    /**
     * @param LogRecordSchema $record
     */
    public function format(array $record): string
    {
        $log = $this
            ->prepare($record)
            ->render()
            ->toArray();

        return $this->toJson($log) . PHP_EOL;
    }

    /**
     * @param LogRecordSchema $record
     */
    protected function prepare(array $record): EcsFieldsCollection
    {
        $record = LogRecord::parse($record);
        $fields = new EcsFieldsCollection($record->context);
        return $fields
            ->loadInitialFields($record)
            ->loadWrappers();
    }
}
