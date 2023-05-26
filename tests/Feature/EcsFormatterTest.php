<?php

namespace Hamidrezaniazi\Pecs\Tests\Feature;

use Carbon\Carbon;
use DateTimeImmutable;
use Hamidrezaniazi\Pecs\Monolog\EcsFormatter;
use Hamidrezaniazi\Pecs\Tests\EcsFieldFactory;
use Hamidrezaniazi\Pecs\Tests\TestCase;

class EcsFormatterTest extends TestCase
{
    private EcsFormatter $formatter;

    protected function setUp(): void
    {
        parent::setUp();
        $this->formatter = new EcsFormatter();
    }

    public function testItShouldFormatWithEmptyData(): void
    {
        $log = $this->formatter->format([]);
        $array = json_decode($log, true);

        $this->assertJson($log);
        $this->assertArrayHasKey('@timestamp', $array);
        $this->assertCount(1, $array);
    }

    public function testItShouldFormatWithNoContext(): void
    {
        $message = $this->faker->sentence();
        $level = $this->faker->word();
        $channel = $this->faker->word();
        $datetime = new DateTimeImmutable($this->faker->dateTime()->format('Y-m-d H:i:s.u'));

        $log = $this->formatter->format([
            'message' => $message,
            'datetime' => $datetime,
            'level_name' => $level,
            'channel' => $channel,
        ]);
        $array = json_decode($log, true);

        $this->assertJson($log);
        $this->assertEquals([
            '@timestamp' => Carbon::parse($datetime)->toIso8601ZuluString(),
            'log' => [
                'level' => $level,
                'logger' => $channel,
            ],
            'message' => $message,
        ], $array);
    }

    public function testItShouldFormatWithContext(): void
    {
        $message = $this->faker->sentence();
        $level = $this->faker->word();
        $channel = $this->faker->word();
        $datetime = new DateTimeImmutable($this->faker->dateTime()->format('Y-m-d H:i:s.u'));
        $field = EcsFieldFactory::create(
            $this->faker->word(),
            [$this->faker->word() => $this->faker->word()],
            [$this->faker->word() => $this->faker->word()],
            [$this->faker->word() => $this->faker->word()],
        );

        $log = $this->formatter->format([
            'message' => $message,
            'datetime' => $datetime,
            'level_name' => $level,
            'channel' => $channel,
            'context' => [$field],
        ]);
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
