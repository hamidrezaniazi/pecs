<?php

namespace Hamidrezaniazi\Pecs\Tests\Unit\Commands;

use Exception;
use Hamidrezaniazi\Pecs\Bin\Commands\AbstractCommandTemplate;
use Hamidrezaniazi\Pecs\Bin\Generator\ClassGenerator;
use Hamidrezaniazi\Pecs\Tests\Unit\UnitTestHelper;
use PHPUnit\Framework\TestCase;

class AbstractCommandTemplateTest extends TestCase
{
    use UnitTestHelper;

    private ClassGenerator $classGenerator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setLogger();

        $this->classGenerator = $this->createMock(ClassGenerator::class);
    }

    public function testEveryExtendedCommandsShouldFollowTheTemplate(): void
    {
        $command = new class ($this->logger, $this->classGenerator) extends AbstractCommandTemplate {
            protected function do(): void
            {
                $this->logger->info('test');
            }
        };

        $command->handle();

        $this->assertEquals([
            AbstractCommandTemplate::SIGNATURE,
            'PHP Elastic Common Schema',
            'test',
        ], $this->getCliMessages());
    }

    public function testEveryExtendedCommandsCanBeInstantiatedStatically(): void
    {
        $command = new class ($this->logger, $this->classGenerator) extends AbstractCommandTemplate {
            protected function do(): void
            {
                $this->logger->info('test');
            }
        };

        $command::execute($this->logger, $this->classGenerator);

        $this->assertEquals([
            AbstractCommandTemplate::SIGNATURE,
            'PHP Elastic Common Schema',
            'test',
        ], $this->getCliMessages());
    }
}
