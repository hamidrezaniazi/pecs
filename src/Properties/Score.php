<?php

namespace Hamidrezaniazi\Pecs\Properties;

use Exception;

class Score
{
    public function __construct(
        public readonly float $value,
    ) {
        if ($this->value > 10 || $this->value < 0) {
            throw new Exception('invalid score value! it should be between 0 to 10');
        }
    }
}
