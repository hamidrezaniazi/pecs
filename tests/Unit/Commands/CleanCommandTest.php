<?php

namespace Hamidrezaniazi\Pecs\Tests\Unit\Commands;

use Hamidrezaniazi\Pecs\Bin\Commands\CleanCommand;
use Hamidrezaniazi\Pecs\Bin\Generator\ClassGenerator;
use Hamidrezaniazi\Pecs\Tests\Unit\UnitTestHelper;
use PHPUnit\Framework\TestCase;

class CleanCommandTest extends TestCase
{
    use UnitTestHelper;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setLogger();
    }

    public function testItCanCleanClasses(): void
    {
        $classGenerator = $this->createMock(ClassGenerator::class);
        $classGenerator->expects($this->once())->method('clean');

        CleanCommand::execute($this->logger, $classGenerator);
    }
}
