<?php

namespace Hamidrezaniazi\Pecs\Tests;

use Faker\Factory;
use Faker\Generator;
use Illuminate\Support\Arr;
use PHPUnit\Framework\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    protected Generator $faker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create();
    }

    protected function assertEqualsMultidimensionalCanonicalizing(array $expected, array $actual): void
    {
        $expected = Arr::dot($expected);
        $actual = Arr::dot($actual);
        ksort($expected);
        ksort($actual);

        $this->assertEquals($expected, $actual);
    }
}
