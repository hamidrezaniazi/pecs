<?php

namespace Hamidrezaniazi\Pecs\Tests\Unit\Fields;

use Hamidrezaniazi\Pecs\Fields\Agent;
use Hamidrezaniazi\Pecs\Tests\ReflectionHelpers;
use PHPUnit\Framework\TestCase;

class AgentTest extends TestCase
{
    use ReflectionHelpers;

    public function testItShouldHaveItsKey(): void
    {
        $agent = new Agent();

        $this->assertEquals('agent', $this->privateCall($agent, 'key'));
        $this->assertEmpty($agent->toArray());
    }

    public function testItShouldGenerateItsBody(): void
    {
        $buildOriginal = 'metricbeat version 7.6.0 (amd64), libbeat 7.6.0 [6a23e8f8f30f5001ba344e4e54d8d9cb82cb107c built 2020-02-05 23:10:10 +0000 UTC]';
        $ephemeralId = '8a4f500f';
        $id = '8a4f500d';
        $name = 'foo';
        $type = 'filebeat';
        $version = '6.0.0-rc2';

        $agent = new Agent(
            buildOriginal: $buildOriginal,
            ephemeralId: $ephemeralId,
            id: $id,
            name: $name,
            type: $type,
            version: $version,
        );

        $this->assertEquals(
            [
                'agent' => [
                    'build' => [
                        'original' => $buildOriginal,
                    ],
                    'ephemeral_id' => $ephemeralId,
                    'id' => $id,
                    'name' => $name,
                    'type' => $type,
                    'version' => $version,
                ],
            ],
            $agent->toArray(),
        );
    }
}
