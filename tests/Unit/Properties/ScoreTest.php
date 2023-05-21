<?php

namespace Hamidrezaniazi\Pecs\Tests\Unit\Properties;

use Hamidrezaniazi\Pecs\Properties\Score;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Hamidrezaniazi\Pecs\Properties\Score
 */
class ScoreTest extends TestCase
{
    public function testItShouldValidateInput(): void
    {
        $this->expectExceptionMessage('invalid score value! it should be between 0 to 10');

        $value = rand(11, 100);
        new Score($value);
    }

    public function testItCanCastItselfToString(): void
    {
        $value = rand(0, 10);
        $percent = new Score($value);

        $this->assertEquals($value, $percent->value);
    }
}
