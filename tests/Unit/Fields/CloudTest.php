<?php

namespace Hamidrezaniazi\Pecs\Tests\Unit\Fields;

use Hamidrezaniazi\Pecs\Fields\Cloud;
use Hamidrezaniazi\Pecs\Tests\ReflectionHelpers;
use PHPUnit\Framework\TestCase;

class CloudTest extends TestCase
{
    use ReflectionHelpers;

    public function testItShouldHaveItsKey(): void
    {
        $cloud = new Cloud();

        $this->assertEquals('cloud', $this->privateCall($cloud, 'key'));
        $this->assertEmpty($cloud->toArray());
    }

    public function testItShouldGenerateItsBody(): void
    {
        $accountId = '666777888999-abc';
        $accountName = 'elastic-dev';
        $availabilityZone = 'us-east-1c';
        $instanceId = 'i-1234567890abcdef0';
        $instanceName = 'e0-prod';
        $machineType = 't2.medium';
        $projectId = 'my-project';
        $projectName = 'my project';
        $provider = 'aws';
        $region = 'us-east-1';
        $serviceName = 'lambda';

        $cloud = new Cloud(
            accountId: $accountId,
            accountName: $accountName,
            availabilityZone: $availabilityZone,
            instanceId: $instanceId,
            instanceName: $instanceName,
            machineType: $machineType,
            projectId: $projectId,
            projectName: $projectName,
            provider: $provider,
            region: $region,
            serviceName: $serviceName,
        );

        $this->assertEquals(
            [
                'cloud' => [
                    'account' => [
                        'id' => $accountId,
                        'name' => $accountName,
                    ],
                    'availability_zone' => $availabilityZone,
                    'instance' => [
                        'id' => $instanceId,
                        'name' => $instanceName,
                    ],
                    'machine' => [
                        'type' => $machineType,
                    ],
                    'project' => [
                        'id' => $projectId,
                        'name' => $projectName,
                    ],
                    'provider' => $provider,
                    'region' => $region,
                    'service' => [
                        'name' => $serviceName,
                    ],
                ],
            ],
            $cloud->toArray(),
        );
    }
}
