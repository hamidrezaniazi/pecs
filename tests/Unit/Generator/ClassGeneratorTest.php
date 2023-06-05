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

    private string $fieldsNamespace = 'Hamidrezaniazi\Pecs\Tests\Unit\Generator';

    private string $listablesNamespace = 'Hamidrezaniazi\Pecs\Tests\Unit\Generator\Properties\Listables';

    private ClassGenerator $generator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->generator = new ClassGenerator(
            __DIR__ . '/stubs',
            $this->fieldsStoringPath,
            $this->fieldsNamespace,
            $this->listableStoringPath,
            $this->listablesNamespace,
        );
    }

    /**
     * @throws JsonException
     */
    protected function tearDown(): void
    {
        $this->generator->clean();
    }

    /**
     * @throws JsonException
     */
    public function testItCanGenerateClasses(): void
    {
        $this->generator->generate();

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
}
