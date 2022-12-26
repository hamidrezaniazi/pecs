<?php

namespace Hamidrezaniazi\Pecs\Tests\Unit\Fields;

use Hamidrezaniazi\Pecs\Fields\Log;
use Hamidrezaniazi\Pecs\Tests\ReflectionHelpers;
use PHPUnit\Framework\TestCase;

class LogTest extends TestCase
{
    use ReflectionHelpers;

    public function testItShouldHaveItsKey(): void
    {
        $log = new Log();

        $this->assertEquals('log', $this->privateCall($log, 'key'));
        $this->assertEmpty($log->toArray());
    }

    public function testItShouldGenerateItsBody(): void
    {
        $filePath = '/var/log/fun-times.log';
        $level = 'warn';
        $logger = 'ecs_channel';
        $originFileLine = 12;
        $originFileName = 'filename.ext';
        $originFunction = 'init';
        $syslogFacilityCode = 23;
        $syslogFacilityName = 'local7';
        $syslogPriority = 135;
        $syslogSeverityCode = 3;
        $syslogSeverityName = 'Error';

        $log = new Log(
            filePath: $filePath,
            level: $level,
            logger: $logger,
            originFileLine: $originFileLine,
            originFileName: $originFileName,
            originFunction: $originFunction,
            syslogFacilityCode: $syslogFacilityCode,
            syslogFacilityName: $syslogFacilityName,
            syslogPriority: $syslogPriority,
            syslogSeverityCode: $syslogSeverityCode,
            syslogSeverityName: $syslogSeverityName,
        );

        $this->assertEquals(
            [
                'log' => [
                    'file' => [
                        'path' => $filePath,
                    ],
                    'level' => $level,
                    'logger' => $logger,
                    'origin' => [
                        'file' => [
                            'line' => $originFileLine,
                            'name' => $originFileName,
                        ],
                        'function' => $originFunction,
                    ],
                    'syslog' => [
                        'facility' => [
                            'code' => $syslogFacilityCode,
                            'name' => $syslogFacilityName,
                        ],
                        'priority' => $syslogPriority,
                        'severity' => [
                            'code' => $syslogSeverityCode,
                            'name' => $syslogSeverityName,
                        ],
                    ],
                ],
            ],
            $log->toArray(),
        );
    }
}
