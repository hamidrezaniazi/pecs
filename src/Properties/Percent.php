<?php

namespace Hamidrezaniazi\Pecs\Properties;

use Exception;

class Percent
{
    public function __construct(
        public readonly float $value,
    ) {
        if ($this->value > 100 || $this->value < 0) {
            throw new Exception('invalid percentage value! it should be between 0 to 100');
        }
    }

    public function scale(): float
    {
        return $this->value / 100;
    }
}
