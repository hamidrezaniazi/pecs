<?php

namespace Hamidrezaniazi\Pecs\Tests\Unit\Fields;

use Hamidrezaniazi\Pecs\Fields\Container;
use Hamidrezaniazi\Pecs\Properties\PairList;
use Hamidrezaniazi\Pecs\Properties\Percent;
use Hamidrezaniazi\Pecs\Properties\ValueList;
use Hamidrezaniazi\Pecs\Tests\ReflectionHelpers;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{
    use ReflectionHelpers;

    public function testItShouldHaveItsKey(): void
    {
        $container = new Container();

        $this->assertEquals('container', $this->privateCall($container, 'key'));
        $this->assertEmpty($container->toArray());
    }

    public function testItShouldGenerateItsBody(): void
    {
        $cpuUsage = 50.55;
        $cpuUsagePercent = new Percent($cpuUsage);

        $memoryUsage = 20.50;
        $memoryUsagePercent = new Percent($memoryUsage);

        $imageHashAll = $this->createMock(ValueList::class);
        $imageHashAllList = ['sha256:f8fefc80e3273dc756f288a63945820d6476ad64883892c771b5e2ece6bf1b26'];
        $imageHashAll->expects($this->once())->method('toArray')->willReturn($imageHashAllList);

        $imageTag = $this->createMock(ValueList::class);
        $imageTagList = ['buz'];
        $imageTag->expects($this->once())->method('toArray')->willReturn($imageTagList);

        $labels = $this->createMock(PairList::class);
        $labelsList = ['foo' => 'bar'];
        $labels->expects($this->once())->method('toArray')->willReturn($labelsList);

        $diskReadBytes = 123;
        $diskWriteBytes = 321;
        $id = 'container-id';
        $imageName = 'alpine';
        $name = 'php';
        $networkEgressBytes = 567;
        $networkIngressBytes = 765;
        $runtime = 'docker';

        $container = new Container(
            cpuUsage: $cpuUsagePercent,
            diskReadBytes: $diskReadBytes,
            diskWriteBytes: $diskWriteBytes,
            id: $id,
            imageHashAll: $imageHashAll,
            imageName: $imageName,
            imageTag: $imageTag,
            labels: $labels,
            memoryUsage: $memoryUsagePercent,
            name: $name,
            networkEgressBytes: $networkEgressBytes,
            networkIngressBytes: $networkIngressBytes,
            runtime: $runtime,
        );

        $this->assertEquals(
            [
                'container' => [
                    'cpu' => [
                        'usage' => $cpuUsage / 100,
                    ],
                    'disk' => [
                        'read' => [
                            'bytes' => $diskReadBytes,
                        ],
                        'write' => [
                            'bytes' => $diskWriteBytes,
                        ],
                    ],
                    'id' => $id,
                    'image' => [
                        'hash' => [
                            'all' => $imageHashAllList,
                        ],
                        'name' => $imageName,
                        'tag' => $imageTagList,
                    ],
                    'labels' => $labelsList,
                    'memory' => [
                        'usage' => $memoryUsage / 100,
                    ],
                    'name' => $name,
                    'network' => [
                        'egress' => [
                            'bytes' => $networkEgressBytes,
                        ],
                        'ingress' => [
                            'bytes' => $networkIngressBytes,
                        ],
                    ],
                    'runtime' => $runtime,
                ],
            ],
            $container->toArray(),
        );
    }
}
