<?php

namespace Hamidrezaniazi\Pecs;

use Carbon\Carbon;
use DateTimeInterface;

class EcsInitialData
{
    public function __construct(
        private ?DateTimeInterface $datetime,
        public readonly string $message,
        public readonly string $levelName,
        public readonly string $channel,
    ) {}

    public function getTimestamp(): Carbon
    {
        return is_null($this->datetime) ? Carbon::now() : Carbon::parse($this->datetime);
    }
}