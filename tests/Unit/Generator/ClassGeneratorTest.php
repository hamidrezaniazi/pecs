<?php

namespace Hamidrezaniazi\Pecs\Tests\Unit\Generator;

use Closure;
use Hamidrezaniazi\Pecs\Bin\Generator\ClassGenerator;
use Hamidrezaniazi\Pecs\Tests\Unit\UnitTestHelper;
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
    use UnitTestHelper;

    private string $fieldsStoringPath = __DIR__ . '/Fields';

    private string $listableStoringPath = __DIR__ . '/Properties/Listables';

    private string $fieldsNamespace = 'Hamidrezaniazi\Pecs\Tests\Unit\Generator';

    private string $listablesNamespace = 'Hamidrezaniazi\Pecs\Tests\Unit\Generator\Properties\Listables';

    private ?Closure $cleanup = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setLogger();
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
}
