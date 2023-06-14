<?php

namespace Hamidrezaniazi\Pecs\Bin\Commands;

use JsonException;

class GenerateCommand extends AbstractCommandTemplate
{
    /**
     * @throws JsonException
     */
    protected function do(): void
    {
        $this->classGenerator->generate();
    }
}
