<?php

namespace Hamidrezaniazi\Pecs\Fields;

use Carbon\Carbon;
use Hamidrezaniazi\Pecs\Properties\ThreatConfidence;
use Hamidrezaniazi\Pecs\Properties\ThreatIndicatorType;
use Hamidrezaniazi\Pecs\Properties\ThreatMarkingTLP;
use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-threat.html */
class ThreatEnrichment extends AbstractEcsField
{
    public function __construct(
        public readonly ?ThreatConfidence $indicatorConfidence = null,
        public readonly ?string $indicatorDescription = null,
        public readonly ?string $indicatorEmailAddress = null,
        public readonly ?Carbon $indicatorFirstSeen = null,
        public readonly ?string $indicatorIp = null,
        public readonly ?Carbon $indicatorLastSeen = null,
        public readonly ?ThreatMarkingTLP $indicatorMarkingTlp = null,
        public readonly ?string $indicatorMarkingTlpVersion = null,
        public readonly ?Carbon $indicatorMarkingModifiedAt = null,
        public readonly ?string $indicatorName = null,
        public readonly ?int $indicatorPort = null,
        public readonly ?string $indicatorProvider = null,
        public readonly ?string $indicatorReference = null,
        public readonly ?int $indicatorScannerStats = null,
        public readonly ?int $indicatorSightings = null,
        public readonly ?ThreatIndicatorType $indicatorType = null,
        public readonly ?string $matchedAtomic = null,
        public readonly ?string $matchedField = null,
        public readonly ?string $matchedId = null,
        public readonly ?Carbon $matchedOccurred = null,
        public readonly ?string $matchedType = null,
        public readonly ?AutonomousSystem $indicatorAs = null,
        public readonly ?File $indicatorFile = null,
        public readonly ?Geo $indicatorGeo = null,
        public readonly ?Registry $indicatorRegistry = null,
        public readonly ?Url $indicatorUrl = null,
        public readonly ?X509 $indicatorX509 = null,
    ) {
        parent::__construct(false);
    }

    protected function key(): ?string
    {
        return null;
    }

    protected function body(): Collection
    {
        return collect([
            'indicator.confidence' => $this->indicatorConfidence?->value,
            'indicator.description' => $this->indicatorDescription,
            'indicator.email.address' => $this->indicatorEmailAddress,
            'indicator.first_seen' => $this->indicatorFirstSeen?->toIso8601ZuluString(),
            'indicator.ip' => $this->indicatorIp,
            'indicator.last_seen' => $this->indicatorLastSeen?->toIso8601ZuluString(),
            'indicator.marking.tlp' => $this->indicatorMarkingTlp?->value,
            'indicator.marking.tlp_version' => $this->indicatorMarkingTlpVersion,
            'indicator.marking.modified_at' => $this->indicatorMarkingModifiedAt?->toIso8601ZuluString(),
            'indicator.name' => $this->indicatorName,
            'indicator.port' => $this->indicatorPort,
            'indicator.provider' => $this->indicatorProvider,
            'indicator.reference' => $this->indicatorReference,
            'indicator.scanner_stats' => $this->indicatorScannerStats,
            'indicator.sightings' => $this->indicatorSightings,
            'indicator.type' => $this->indicatorType?->value,
            'matched.atomic' => $this->matchedAtomic,
            'matched.field' => $this->matchedField,
            'matched.id' => $this->matchedId,
            'matched.occurred' => $this->matchedOccurred?->toIso8601ZuluString(),
            'matched.type' => $this->matchedType,
            'indicator.as' => $this->indicatorAs?->getBody(),
            'indicator.file' => $this->indicatorFile?->getBody(),
            'indicator.geo' => $this->indicatorGeo?->getBody(),
            'indicator.registry' => $this->indicatorRegistry?->getBody(),
            'indicator.url' => $this->indicatorUrl?->getBody(),
            'indicator.x509' => $this->indicatorX509?->getBody(),
        ]);
    }
}
