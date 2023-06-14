<?php

namespace Hamidrezaniazi\Pecs\Tests\Unit\Commands;

use Hamidrezaniazi\Pecs\Bin\Commands\GenerateCommand;
use Hamidrezaniazi\Pecs\Bin\Generator\ClassGenerator;
use Hamidrezaniazi\Pecs\Tests\Unit\UnitTestHelper;
use PHPUnit\Framework\TestCase;

class GenerateCommandTest extends TestCase
{
    use UnitTestHelper;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setLogger();
    }

    public function testItCanGenerateClasses(): void
    {
        $classGenerator = $this->createMock(ClassGenerator::class);
        $classGenerator->expects($this->once())->method('generate');

        GenerateCommand::execute($this->logger, $classGenerator);
    }
}
