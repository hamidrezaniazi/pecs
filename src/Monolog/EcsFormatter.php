<?php

namespace Hamidrezaniazi\Pecs\Monolog;

use Hamidrezaniazi\Pecs\EcsFieldsCollection;
use Monolog\Formatter\NormalizerFormatter;

/** @phpstan-import-type LogRecordSchema from LogRecord */
class EcsFormatter extends NormalizerFormatter
{
    /** @param LogRecordSchema $record */
    public function format(array $record): string
    {
        $record = LogRecord::parse($record);
        $fields = new EcsFieldsCollection($record->context);
        $log = $fields
            ->loadInitialFields($record)
            ->loadWrappers()
            ->render()
            ->toArray();

        return $this->toJson($log) . PHP_EOL;
    }
}
