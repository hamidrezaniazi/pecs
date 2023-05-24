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
            'file.path' => $this->filePath,
            'level' => $this->level,
            'logger' => $this->logger,
            'origin.file.line' => $this->originFileLine,
            'origin.file.name' => $this->originFileName,
            'origin.function' => $this->originFunction,
            'syslog.facility.code' => $this->syslogFacilityCode,
            'syslog.facility.name' => $this->syslogFacilityName,
            'syslog.priority' => $this->syslogPriority,
            'syslog.severity.code' => $this->syslogSeverityCode,
            'syslog.severity.name' => $this->syslogSeverityName,
        ]);
    }
}
