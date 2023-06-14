<?php

namespace Hamidrezaniazi\Pecs\Tests\Unit\Generator;

use Closure;
use Hamidrezaniazi\Pecs\Bin\Generator\ClassGenerator;
use JsonException;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use Throwable;

/**
 * @covers \Hamidrezaniazi\Pecs\Bin\Generator\ClassGenerator
 */
class ClassGeneratorTest extends TestCase
{
    private Logger $logger;

    private string $fieldsStoringPath = __DIR__ . '/Fields';

    private string $listableStoringPath = __DIR__ . '/Properties/Listables';

    private string $fieldsNamespace = 'Hamidrezaniazi\Pecs\Tests\Unit\Generator';

    private string $listablesNamespace = 'Hamidrezaniazi\Pecs\Tests\Unit\Generator\Properties\Listables';

    private ?Closure $cleanup = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->logger = new Logger(name: 'test', handlers: [new class () extends AbstractProcessingHandler {
            public array $messages = [];

            protected function write(array $record): void
            {
                $this->messages[] = $record['message'];
            }
        }]);
    }

    protected function tearDown(): void
    {
        if ($this->cleanup) {
            ($this->cleanup)();
        }

        $this->removeDirectoryRecursive($this->fieldsStoringPath);
        $this->removeDirectoryRecursive($this->listableStoringPath);

        parent::tearDown();
    }

    /**
     * @throws JsonException
     */
    public function testItCanGenerateClasses(): void
    {
        $generator = new ClassGenerator(
            $this->logger,
            __DIR__ . '/stubs',
            $this->fieldsStoringPath,
            $this->fieldsNamespace,
            $this->listableStoringPath,
            $this->listablesNamespace,
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

        $this->assertEquals([
            '3 schemas have been found to generate the classes...',
            'DefaultClass',
            'ListableClass',
            'ListableClassList',
            'NestedClass',
        ], $this->getCliMessages());
    }

    /**
     * @throws JsonException
     */
    public function testItCanCleanTheGeneratedClasses(): void
    {
        $generator = new ClassGenerator(
            $this->logger,
            __DIR__ . '/stubs',
            $this->fieldsStoringPath,
            $this->fieldsNamespace,
            $this->listableStoringPath,
            $this->listablesNamespace,
        );

        $generator->generate();
        $generator->clean();

        $this->assertEmpty(array_diff(scandir($this->fieldsStoringPath), ['.', '..']));
        $this->assertEmpty(array_diff(scandir($this->listableStoringPath), ['.', '..']));

        $this->assertEquals([
            '3 schemas have been found to generate the classes...',
            'DefaultClass',
            'ListableClass',
            'ListableClassList',
            'NestedClass',
            '3 schemas have been found to remove the classes...',
            'DefaultClass',
            'ListableClass',
            'ListableClassList',
            'NestedClass',
        ], $this->getCliMessages());
    }

    /**
     * @throws JsonException
     */
    public function testItThrowsExceptionWhenConfigPathIsWrong(): void
    {
        $generator = new ClassGenerator(
            $this->logger,
            __DIR__ . '/wrong-path',
            $this->fieldsStoringPath,
            $this->fieldsNamespace,
            $this->listableStoringPath,
            $this->listablesNamespace,
        );

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Could not read config directory');

        $generator->generate();
    }

    /**
     * @throws JsonException
     */
    public function testItThrowsExceptionWhenWrongJsonIsDetected(): void
    {
        $wrongFile = __DIR__ . '/stubs/wrong.json';
        file_put_contents($wrongFile, 'wrong-json');

        $this->cleanup = fn () => unlink($wrongFile);

        $generator = new ClassGenerator(
            $this->logger,
            __DIR__ . '/stubs',
            $this->fieldsStoringPath,
            $this->fieldsNamespace,
            $this->listableStoringPath,
            $this->listablesNamespace,
        );

        $this->expectException(JsonException::class);
        $this->expectExceptionMessage("Could not parse {$wrongFile}");

        $generator->generate();
    }

    private function removeDirectoryRecursive(string $storingPath): void
    {
        try {
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
        } catch (Throwable) {
            // Do nothing
        }
    }

    private function getCliMessages(): array
    {
        $handler = $this->logger->getHandlers()[0];

        return $handler->messages;
    }
}
