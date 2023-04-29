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
    private string $storingPath = __DIR__ . '/Fields';

    protected function tearDown(): void
    {
        $this->removeDirectoryRecursive($this->storingPath);
    }

    /**
     * @throws JsonException
     */
    public function testItCanGenerateClasses(): void
    {
        $namespace = 'Hamidrezaniazi\Pecs\Tests\Unit\Generator';
        $generator = new ClassGenerator(
            __DIR__ . '/stubs',
            $this->storingPath,
            $namespace,
        );

        $generator->generate();

        $this->assertEquals(
            file_get_contents(__DIR__ . '/stubs/default.stub.php'),
            file_get_contents($this->storingPath . '/DefaultClass.php'),
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/stubs/nested.stub.php'),
            file_get_contents($this->storingPath . '/NestedClass.php'),
        );
    }

    private function removeDirectoryRecursive(string $storingPath): void
    {
        $files = glob($storingPath . '/*');
        if ($files !== false) {
            foreach ($files as $file) {
                is_dir($file) ? $this->removeDirectoryRecursive($file) : unlink($file);
            }
            rmdir($storingPath);
        }
    }
}
