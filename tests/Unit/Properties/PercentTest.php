<?php

namespace Hamidrezaniazi\Pecs\Tests\Unit\Properties;

use Hamidrezaniazi\Pecs\Properties\Percent;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Hamidrezaniazi\Pecs\Properties\Percent
 */
class PercentTest extends TestCase
{
    public function testItShouldValidateInput(): void
    {
        $this->expectExceptionMessage('invalid percentage value! it should be between 0 to 100');

        $value = rand(101, 1001);
        new Percent($value);
    }

    public function testItCanCastItselfToString(): void
    {
        $value = rand(0, 100);
        $percent = new Percent($value);

        $this->assertEquals($value, $percent->value);
    }

    public function testItCanCalculateScale(): void
    {
        $value = rand(0, 100);
        $percent = new Percent($value);

        $this->assertEquals($value / 100, $percent->scale());
    }
}
