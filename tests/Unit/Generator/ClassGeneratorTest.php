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
    private string $fieldsStoringPath = __DIR__ . '/Fields';

    private string $listableStoringPath = __DIR__ . '/Properties/Listables';

    protected function tearDown(): void
    {
        $this->removeDirectoryRecursive($this->fieldsStoringPath);
        $this->removeDirectoryRecursive($this->listableStoringPath);
    }

    /**
     * @throws JsonException
     */
    public function testItCanGenerateClasses(): void
    {
        $fieldsNamespace = 'Hamidrezaniazi\Pecs\Tests\Unit\Generator';
        $listablesNamespace = 'Hamidrezaniazi\Pecs\Tests\Unit\Generator\Properties\Listables';
        $generator = new ClassGenerator(
            __DIR__ . '/stubs',
            $this->fieldsStoringPath,
            $fieldsNamespace,
            $this->listableStoringPath,
            $listablesNamespace,
        );

        $generator->generate();

        $this->assertEquals(
            file_get_contents(__DIR__ . '/stubs/default.stub.php'),
            file_get_contents($this->fieldsStoringPath . '/DefaultClass.php'),
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/stubs/nested.stub.php'),
            file_get_contents($this->fieldsStoringPath . '/NestedClass.php'),
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/stubs/listable.stub.php'),
            file_get_contents($this->fieldsStoringPath . '/ListableClass.php'),
        );

        $this->assertEquals(
            file_get_contents(__DIR__ . '/stubs/listable_list.stub.php'),
            file_get_contents($this->listableStoringPath . '/ListableClassList.php'),
        );
    }

    private function removeDirectoryRecursive(string $storingPath): void
    {
        $files = glob($storingPath . '/*');
        if ($files !== false) {
            foreach ($files as $file) {
                if (is_dir($file)) {
                    $this->removeDirectoryRecursive($file);
                } else {
                    unlink($file);
                }
            }
        }
        rmdir($storingPath);

        $parentDir = dirname($storingPath);
        if ($parentDir !== '.') {
            $parentFiles = glob($parentDir . '/*');
            if ($parentFiles !== false && is_array($parentFiles) && count($parentFiles) === 0) {
                rmdir($parentDir);
            }
        }
    }
}
