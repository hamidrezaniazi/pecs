<?php

namespace Hamidrezaniazi\Pecs\Bin\Commands;

use Hamidrezaniazi\Pecs\Bin\Generator\ClassGenerator;
use Monolog\Logger;

interface CommandInterface
{
    public function __construct(Logger $logger, ClassGenerator $classGenerator);
}
