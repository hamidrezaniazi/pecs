<?php

namespace Hamidrezaniazi\Pecs\Tests\Unit\Fields;

use Carbon\Carbon;
use Hamidrezaniazi\Pecs\Fields\Event;
use Hamidrezaniazi\Pecs\Properties\AgentIdStatus;
use Hamidrezaniazi\Pecs\Properties\EventCategory;
use Hamidrezaniazi\Pecs\Properties\EventKind;
use Hamidrezaniazi\Pecs\Properties\EventOutcome;
use Hamidrezaniazi\Pecs\Properties\EventType;
use Hamidrezaniazi\Pecs\Properties\Percent;
use Hamidrezaniazi\Pecs\Tests\ReflectionHelpers;
use Hamidrezaniazi\Pecs\Tests\Unit\UnitTestHelper;
use PHPUnit\Framework\TestCase;

class EventTest extends TestCase
{
    use ReflectionHelpers;
    use UnitTestHelper;

    public function testItShouldHaveItsKey(): void
    {
        $event = new Event();

        $this->assertEquals('event', $this->privateCall($event, 'key'));
        $this->assertEmpty($event->toArray());
    }

    public function testItShouldGenerateItsBody(): void
    {
        Carbon::setTestNow('2022-02-02T22:22:22+01:00');

        $timezone = 'Europe/Amsterdam';
        $action = 'file-created';
        $code = '123';
        $created = Carbon::now($timezone);
        $dataset = 'apache.access';
        $duration = 1000000000;
        $end = Carbon::now($timezone)->addSeconds(10);
        $hash = '123456789012345678901234567890ABCD';
        $id = '8a4f500d';
        $ingested = Carbon::now($timezone)->addSeconds(15);
        $module = 'apache';
        $original = 'Sep 19 08:26:10 host';
        $provider = 'kernel';
        $reason = 'Terminated an unexpected process';
        $reference = 'https://system.example.com/event/#0001234';
        $riskScore = 321.0;
        $riskScoreNorm = 50.0;
        $sequence = 5;
        $severity = 7;
        $start = Carbon::now($timezone)->addSeconds(5);
        $url = 'https://mysystem.example.com/alert/5271dedb-f5b0-4218-87f0-4ac4870a38fe';

        $agentIdStatus = $this->random(AgentIdStatus::cases());

        $eventCategory = $this->random(EventCategory::cases());

        $eventKind = $this->random(EventKind::cases());

        $eventOutcome = $this->random(EventOutcome::cases());

        $eventType = $this->random(EventType::cases());

        $percent = new Percent($riskScoreNorm);

        $event = new Event(
            action: $action,
            agentIdStatus: $agentIdStatus,
            category: $eventCategory,
            code: $code,
            created: $created,
            dataset: $dataset,
            duration: $duration,
            end: $end,
            hash: $hash,
            id: $id,
            ingested: $ingested,
            kind: $eventKind,
            module: $module,
            original: $original,
            outcome: $eventOutcome,
            provider: $provider,
            reason: $reason,
            reference: $reference,
            riskScore: $riskScore,
            riskScoreNorm: $percent,
            sequence: $sequence,
            severity: $severity,
            start: $start,
            type: $eventType,
            url: $url,
        );

        $this->assertEquals(
            [
                'event' => [
                    'action' => $action,
                    'status' => $agentIdStatus->value,
                    'category' => $eventCategory->value,
                    'code' => $code,
                    'created' => '2022-02-02T22:22:22+01:00',
                    'dataset' => $dataset,
                    'duration' => $duration,
                    'end' => '2022-02-02T22:22:32+01:00',
                    'hash' => $hash,
                    'id' => $id,
                    'ingested' => '2022-02-02T22:22:37+01:00',
                    'kind' => $eventKind->value,
                    'module' => $module,
                    'original' => $original,
                    'outcome' => $eventOutcome->value,
                    'provider' => $provider,
                    'reason' => $reason,
                    'reference' => $reference,
                    'risk_score' => $riskScore,
                    'risk_score_norm' => $riskScoreNorm,
                    'sequence' => $sequence,
                    'severity' => $severity,
                    'start' => '2022-02-02T22:22:27+01:00',
                    'timezone' => $timezone,
                    'type' => $eventType->value,
                    'url' => $url,
                ],
            ],
            $event->toArray(),
        );
    }

    /**
     * @dataProvider timeKeyProvider
     */
    public function testTimezoneShouldSetIfOneOfTheTimeValuesIsAvailable(?string $timeKey): void
    {
        if (is_null($timeKey)) {
            $event = new Event();
            $this->assertNull($event->timezone);
        } else {
            Carbon::setTestNow('2022-02-02T22:22:22+01:00');
            $timezone = 'Europe/Amsterdam';
            $time = Carbon::now()->setTimezone($timezone);
            $event = new Event(start: $time);
            $this->assertEquals($timezone, $event->timezone);
        }
    }

    public function timeKeyProvider(): array
    {
        return [
            [null],
            ['created'],
            ['end'],
            ['ingested'],
            ['start'],
        ];
    }
}
