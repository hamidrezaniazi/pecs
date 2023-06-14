<?php

namespace Hamidrezaniazi\Pecs\Bin\Commands;

use Hamidrezaniazi\Pecs\Bin\Generator\ClassGenerator;
use Monolog\Logger;

abstract class AbstractCommandTemplate implements CommandInterface
{
    public const SIGNATURE = <<<LOGO
_________________________________
___  __ \__  ____/_  ____/_  ___/
__  /_/ /_  __/  _  /    _____ \
_  ____/_  /___  / /___  ____/ /
/_/     /_____/  \____/  /____/

LOGO;

    public function __construct(protected readonly Logger $logger, protected readonly ClassGenerator $classGenerator)
    {
    }

    public function handle(): void
    {
        $this->greeting();
        $this->do();
    }

    protected function greeting(): void
    {
        $this->logger->info(self::SIGNATURE);
        $this->logger->info('PHP Elastic Common Schema');
    }

    public static function execute(Logger $logger, ClassGenerator $classGenerator): void
    {
        (new static($logger, $classGenerator))->handle();
    }

    abstract protected function do(): void;
}
