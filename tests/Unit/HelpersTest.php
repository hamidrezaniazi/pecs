<?php

namespace Hamidrezaniazi\Pecs\Tests\Unit;

use Monolog\Logger;
use PHPUnit\Framework\TestCase;

use function Hamidrezaniazi\Pecs\Bin\get_logger;

class HelpersTest extends TestCase
{
    public function testItCanInstantiateLogger(): void
    {
        $logger = get_logger();

        $this->assertInstanceOf(Logger::class, $logger);
        $this->assertSame('cli', $logger->getName());

        $handler = $logger->getHandlers()[0];

        $this->assertSame('php://stdout', $handler->getUrl());
        $this->assertSame('test' . PHP_EOL, $handler->getFormatter()->format(['message' => 'test']));
    }
}
