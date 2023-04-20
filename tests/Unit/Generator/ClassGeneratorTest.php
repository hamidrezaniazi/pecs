<?php

namespace Hamidrezaniazi\Pecs\Tests\Unit\Generator;

use Hamidrezaniazi\Pecs\Generator\ClassGenerator;
use JsonException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Hamidrezaniazi\Pecs\Generator\ClassGenerator
 */
class ClassGeneratorTest extends TestCase
{
    /**
     * @throws JsonException
     */
    public function testItCanGenerateClasses(): void
    {
        $namespace = 'Hamidrezaniazi\Pecs\Tests\Unit\Generator';
        $storingPath = __DIR__ . '/Fields';
        $generator = new ClassGenerator(
            __DIR__ . '/stubs',
            $storingPath,
            $namespace,
        );

        $generator->generate();

        $this->assertEquals(
            file_get_contents(__DIR__ . '/stubs/default.stub.php'),
            file_get_contents($storingPath . '/DefaultClass.php'),
        );
    }
}
