<?php

namespace Hamidrezaniazi\Pecs\Tests\Feature\Monolog;

use Carbon\Carbon;
use DateTimeImmutable;
use Hamidrezaniazi\Pecs\Monolog\EcsFormatter;
use Hamidrezaniazi\Pecs\Tests\EcsFieldFactory;
use Hamidrezaniazi\Pecs\Tests\TestCase;
use Monolog\Level;
use Monolog\LogRecord;

class EcsFormatterTest extends TestCase
{
    private EcsFormatter $formatter;

    protected function setUp(): void
    {
        parent::setUp();
        $this->formatter = new EcsFormatter();
    }

    public function testItShouldFormatWithNoContext(): void
    {
        $message = $this->faker->sentence();
        $level = Level::fromValue($this->faker->randomElement(Level::VALUES));
        $channel = $this->faker->word();
        $datetime = $this->faker->dateTime();

        $log = $this->formatter->format(new LogRecord(
            datetime: DateTimeImmutable::createFromMutable($datetime),
            channel: $channel,
            level: $level,
            message: $message,
        ));
        $array = json_decode($log, true);

        $this->assertJson($log);
        $this->assertEquals([
            '@timestamp' => Carbon::parse($datetime)->toIso8601ZuluString(),
            'log' => [
                'level' => $level->getName(),
                'logger' => $channel,
            ],
            'message' => $message,
        ], $array);
    }

    public function testItShouldFormatWithContext(): void
    {
        $message = $this->faker->sentence();
        $level = Level::fromValue($this->faker->randomElement(Level::VALUES));
        $channel = $this->faker->word();
        $datetime = $this->faker->dateTime();
        $field = EcsFieldFactory::create(
            $this->faker->word(),
            [$this->faker->word() => $this->faker->word()],
            [$this->faker->word() => $this->faker->word()],
            [$this->faker->word() => $this->faker->word()],
        );

        $log = $this->formatter->format(new LogRecord(
            datetime: DateTimeImmutable::createFromMutable($datetime),
            channel: $channel,
            level: $level,
            message: $message,
            context: [$field],
        ));
        $array = json_decode($log, true);

        $this->assertJson($log);
        $this->assertEquals([
            '@timestamp' => Carbon::parse($datetime)->toIso8601ZuluString(),
            'log' => [
                'level' => $level,
                'logger' => $channel,
            ],
            'message' => $message,
            ...$field->toArray(),
        ], $array);
    }
}
