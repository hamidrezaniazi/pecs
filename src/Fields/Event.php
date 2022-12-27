<?php

namespace Hamidrezaniazi\Pecs\Fields;

use Carbon\CarbonTimeZone;
use Hamidrezaniazi\Pecs\Properties\AgentIdStatus;
use Hamidrezaniazi\Pecs\Properties\EventCategory;
use Hamidrezaniazi\Pecs\Properties\EventKind;
use Hamidrezaniazi\Pecs\Properties\EventOutcome;
use Hamidrezaniazi\Pecs\Properties\EventType;
use Hamidrezaniazi\Pecs\Properties\Percent;
use Carbon\Carbon;
use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-event.html */
class Event extends AbstractEcsField
{
    public readonly ?string $timezone;

    public function __construct(
        public readonly ?string $action = null,
        public readonly ?AgentIdStatus $agentIdStatus = null,
        public readonly ?EventCategory $category = null,
        public readonly ?string $code = null,
        public readonly ?Carbon $created = null,
        public readonly ?string $dataset = null,
        public readonly ?int $duration = null,
        public readonly ?Carbon $end = null,
        public readonly ?string $hash = null,
        public readonly ?string $id = null,
        public readonly ?Carbon $ingested = null,
        public readonly ?EventKind $kind = null,
        public readonly ?string $module = null,
        public readonly ?string $original = null,
        public readonly ?EventOutcome $outcome = null,
        public readonly ?string $provider = null,
        public readonly ?string $reason = null,
        public readonly ?string $reference = null,
        public readonly ?float $riskScore = null,
        public readonly ?Percent $riskScoreNorm = null,
        public readonly ?int $sequence = null,
        public readonly ?int $severity = null,
        public readonly ?Carbon $start = null,
        public readonly ?EventType $type = null,
        public readonly ?string $url = null,
    ) {
        parent::__construct();
        $this->timezone = collect([
            $this->created?->getTimezone(),
            $this->end?->getTimezone(),
            $this->ingested?->getTimezone(),
            $this->start?->getTimezone(),
        ])->first(fn(?CarbonTimeZone $timezone) => !is_null($timezone));
    }

    protected function key(): ?string
    {
        return 'event';
    }

    protected function body(): Collection
    {
        return collect([
            'action' => $this->action,
            'status' => $this->agentIdStatus?->value,
            'category' => $this->category?->value,
            'code' => $this->code,
            'created' => $this->created?->toIso8601String(),
            'dataset' => $this->dataset,
            'duration' => $this->duration,
            'end' => $this->end?->toIso8601String(),
            'hash' => $this->hash,
            'id' => $this->id,
            'ingested' => $this->ingested?->toIso8601String(),
            'kind' => $this->kind?->value,
            'module' => $this->module,
            'original' => $this->original,
            'outcome' => $this->outcome?->value,
            'provider' => $this->provider,
            'reason' => $this->reason,
            'reference' => $this->reference,
            'risk_score' => $this->riskScore,
            'risk_score_norm' => $this->riskScoreNorm?->value,
            'sequence' => $this->sequence,
            'severity' => $this->severity,
            'start' => $this->start?->toIso8601String(),
            'timezone' => $this->timezone,
            'type' => $this->type?->value,
            'url' => $this->url,
        ]);
    }
}
