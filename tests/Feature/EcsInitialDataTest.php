<?php

namespace Hamidrezaniazi\Pecs\Tests\Feature;

use Carbon\Carbon;
use DateTime;
use Faker\Factory;
use Hamidrezaniazi\Pecs\EcsInitialData;
use Hamidrezaniazi\Pecs\Tests\TestCase;

class EcsInitialDataTest extends TestCase
{
    /** @dataProvider ecsInitialDataProvider */
    public function testItShouldReturnNullSafeTimestamp(?DateTime $dateTime): void
    {
        $timestamp = $this->getNullSafeDatetime($dateTime);

        $this->assertEquals(
            $timestamp,
            (new EcsInitialData($dateTime, $this->faker->word, $this->faker->word, $this->faker->word))->getTimestamp()
        );
    }

    public function ecsInitialDataProvider(): array
    {
        return [
            'without_datetime' => [null],
            'with_datetime' => [Factory::create()->dateTime()],
        ];
    }

    private function getNullSafeDatetime(?DateTime $datetime): DateTime
    {
        if (!is_null($datetime)) {
            return $datetime;
        }

        $now = $this->faker->dateTime();
        Carbon::setTestNow($now);

        return $now;
    }
}