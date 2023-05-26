<?php

namespace Hamidrezaniazi\Pecs\Monolog;

use Carbon\Carbon;
use DateTimeImmutable;
use Hamidrezaniazi\Pecs\Fields\AbstractEcsField;

/**
 * @link https://github.com/Seldaek/monolog/blob/main/doc/message-structure.md
 * @phpstan-type LogRecordSchema = array{
 *     "message": string,
 *     "level_name": string,
 *     "channel": string,
 *     "context"?: array<int, AbstractEcsField>,
 *     "datetime"?: DateTimeImmutable
 * }
 */
class LogRecord
{
    public function __construct(
        public readonly Carbon $datetime,
        public readonly ?string $channel = null,
        public readonly ?string $level = null,
        public readonly ?string $message = null,
        /** @var array<int, AbstractEcsField> $context */
        public readonly array $context = [],
    ) {}

    public static function parse(array $record): self
    {
        return new self(
            datetime: array_key_exists('datetime', $record) ? Carbon::parse($record['datetime']) : Carbon::now(),
            channel: $record['channel'] ?? null,
            level: $record['level_name'] ?? null,
            message: $record['message'] ?? null,
            context: $record['context'] ?? [],
        );
    }
}
