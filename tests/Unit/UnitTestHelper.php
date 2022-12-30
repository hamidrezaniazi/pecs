<?php

namespace Hamidrezaniazi\Pecs\Tests\Unit;

trait UnitTestHelper
{
    protected function random(array $cases): mixed
    {
        return $cases[array_rand($cases)];
    }
}
