<?php

namespace Hamidrezaniazi\Pecs\Bin\Commands;

use JsonException;

class CleanCommand extends AbstractCommandTemplate
{
    /**
     * @throws JsonException
     */
    protected function do(): void
    {
        $this->classGenerator->clean();
    }
}
