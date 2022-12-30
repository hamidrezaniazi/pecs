<?php

namespace Hamidrezaniazi\Pecs\Tests\Unit\Fields;

use Hamidrezaniazi\Pecs\Fields\DataStream;
use Hamidrezaniazi\Pecs\Properties\DataStreamType;
use Hamidrezaniazi\Pecs\Tests\ReflectionHelpers;
use Hamidrezaniazi\Pecs\Tests\Unit\UnitTestHelper;
use PHPUnit\Framework\TestCase;

class DataStreamTest extends TestCase
{
    use ReflectionHelpers;
    use UnitTestHelper;

    public function testItShouldHaveItsKey(): void
    {
        $dataStream = new DataStream();

        $this->assertEquals('data_stream', $this->privateCall($dataStream, 'key'));
        $this->assertEquals(
            [
                'data_stream' => [
                    'namespace' => 'default',
                ],
            ],
            $dataStream->toArray()
        );
    }

    public function testItShouldGenerateItsBody(): void
    {
        $dataset = 'nginx.access';
        $namespace = 'production';
        $type = $this->random(DataStreamType::cases());

        $dataStream = new DataStream(
            dataset: $dataset,
            namespace: $namespace,
            type: $type,
        );

        $this->assertEquals(
            [
                'data_stream' => [
                    'dataset' => $dataset,
                    'namespace' => $namespace,
                    'type' => $type->value
                ],
            ],
            $dataStream->toArray(),
        );
    }
}
