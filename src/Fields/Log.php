<?php

namespace Hamidrezaniazi\Pecs\Fields;

use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-log.html */
class Log extends AbstractEcsField
{
    public function __construct(
        public readonly ?string $filePath = null,
        public readonly ?string $level = null,
        public readonly ?string $logger = null,
        public readonly ?int $originFileLine = null,
        public readonly ?string $originFileName = null,
        public readonly ?string $originFunction = null,
        public readonly ?int $syslogFacilityCode = null,
        public readonly ?string $syslogFacilityName = null,
        public readonly ?int $syslogPriority = null,
        public readonly ?int $syslogSeverityCode = null,
        public readonly ?string $syslogSeverityName = null,
    ) {
        parent::__construct();
    }

    protected function key(): ?string
    {
        return 'log';
    }

    protected function body(): Collection
    {
        return collect([
            'file' => [
                'path' => $this->filePath,
            ],
            'level' => $this->level,
            'logger' => $this->logger,
            'origin' => [
                'file' => [
                    'line' => $this->originFileLine,
                    'name' => $this->originFileName,
                ],
                'function' => $this->originFunction,
            ],
            'syslog' => [
                'facility' => [
                    'code' => $this->syslogFacilityCode,
                    'name' => $this->syslogFacilityName,
                ],
                'priority' => $this->syslogPriority,
                'severity' => [
                    'code' => $this->syslogSeverityCode,
                    'name' => $this->syslogSeverityName,
                ],
            ],
        ]);
    }
}
