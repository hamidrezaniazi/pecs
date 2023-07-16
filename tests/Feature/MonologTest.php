<?php

namespace Hamidrezaniazi\Pecs\Tests\Feature;

use Hamidrezaniazi\Pecs\Monolog\EcsFormatter;
use Hamidrezaniazi\Pecs\Tests\EcsFieldFactory;
use Hamidrezaniazi\Pecs\Tests\TestCase;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class MonologTest extends TestCase
{
    private string $log = __DIR__ . '/test';

    protected function tearDown(): void
    {
        parent::tearDown();
        unlink($this->log);
    }

    public function testItCanIntegrateWithMonolog(): void
    {
        $loggerName = $this->faker->word();
        $log = new Logger($loggerName);
        $handler = new StreamHandler($this->log);

        $log->pushHandler($handler->setFormatter(new EcsFormatter()));

        $wrapper = EcsFieldFactory::create(
            $this->faker->unique()->word(),
            [$this->faker->word() => $this->faker->word()],
            [$this->faker->word() => $this->faker->word()],
        );
        $field = EcsFieldFactory::create(
            $this->faker->unique()->word(),
            [$this->faker->word() => $this->faker->word()],
            [$this->faker->word() => $this->faker->word()],
            [$wrapper]
        );
        $message = $this->faker->sentence();

        $expected = [
            ...$wrapper->toArray(),
            ...$field->toArray(),
            'message' => $message,
            'log' => [
                'level' => 'INFO',
                'logger' => $loggerName,
            ]
        ];

        $log->info($message, [$field]);

        $file = file_get_contents($this->log) ?: '';

        $this->assertStringEndsWith(PHP_EOL, $file);

        $array = json_decode($file, true);

        $this->assertIsArray($array);
        $this->assertArrayHasKey('@timestamp', $array);

        unset($array['@timestamp']);

        $this->assertEquals($expected, $array);
    }
}
