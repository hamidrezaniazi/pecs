<?php

namespace Hamidrezaniazi\Pecs\Tests\Feature;

use Carbon\Carbon;
use DateTime;
use Faker\Factory;
use Hamidrezaniazi\Pecs\LogRecord;
use Hamidrezaniazi\Pecs\Tests\TestCase;

class LogRecordsTest extends TestCase
{
    public function testItShouldNotBreakWithEmptyArray(): void
    {
        $record = LogRecord::parse([]);

        $this->assertNull($record->channel);
        $this->assertNull($record->level);
        $this->assertNull($record->message);
        $this->assertEmpty($record->context);
        $this->assertNotNull($record->datetime);
    }

    /** @dataProvider ecsInitialDataProvider */
    public function testItShouldSetNullSafeTimestamp(?DateTime $dateTime): void
    {
        $timestamp = $this->getNullSafeDatetime($dateTime);

        $this->assertEquals(
            $timestamp,
            LogRecord::parse([
                'datetime' => $dateTime,
                'message' => $this->faker->word,
                'level_name' => $this->faker->word,
                'channel' => $this->faker->word,
            ])->datetime
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
