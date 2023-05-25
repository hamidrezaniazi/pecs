<?php

namespace Hamidrezaniazi\Pecs\Fields;

use Carbon\Carbon;
use Hamidrezaniazi\Pecs\Properties\Listables\SoftwarePlatformList;
use Hamidrezaniazi\Pecs\Properties\Listables\ThreatEnrichmentList;
use Hamidrezaniazi\Pecs\Properties\SoftwareType;
use Hamidrezaniazi\Pecs\Properties\ThreatConfidence;
use Hamidrezaniazi\Pecs\Properties\ThreatIndicatorType;
use Hamidrezaniazi\Pecs\Properties\ThreatMarkingTLP;
use Hamidrezaniazi\Pecs\Properties\ValueList;
use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-threat.html */
class Threat extends AbstractEcsField
{
    public function __construct(
        public readonly ?ThreatEnrichmentList $enrichments = null,
        public readonly ?string $feedDashboardId = null,
        public readonly ?string $feedDescription = null,
        public readonly ?string $feedName = null,
        public readonly ?string $feedReference = null,
        public readonly ?string $framework = null,
        public readonly ?ValueList $groupAlias = null,
        public readonly ?string $groupId = null,
        public readonly ?string $groupName = null,
        public readonly ?string $groupReference = null,
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
        public readonly ?ValueList $softwareAlias = null,
        public readonly ?string $softwareId = null,
        public readonly ?string $softwareName = null,
        public readonly ?SoftwarePlatformList $softwarePlatform = null,
        public readonly ?string $softwareReference = null,
        public readonly ?SoftwareType $softwareType = null,
        public readonly ?string $tacticId = null,
        public readonly ?string $tacticName = null,
        public readonly ?string $tacticReference = null,
        public readonly ?ValueList $techniqueId = null,
        public readonly ?ValueList $techniqueName = null,
        public readonly ?ValueList $techniqueReference = null,
        public readonly ?ValueList $techniqueSubtechniqueId = null,
        public readonly ?ValueList $techniqueSubtechniqueName = null,
        public readonly ?ValueList $techniqueSubtechniqueReference = null,
        public readonly ?AutonomousSystem $indicatorAs = null,
        public readonly ?File $indicatorFile = null,
        public readonly ?Geo $indicatorGeo = null,
        public readonly ?Registry $indicatorRegistry = null,
        public readonly ?Url $indicatorUrl = null,
        public readonly ?X509 $indicatorX509 = null,
    ) {
        parent::__construct();
    }

    protected function key(): ?string
    {
        return 'threat';
    }

    protected function body(): Collection
    {
        return collect([
            'enrichments' => $this->enrichments?->toArray(),
            'feed.dashboard_id' => $this->feedDashboardId,
            'feed.description' => $this->feedDescription,
            'feed.name' => $this->feedName,
            'feed.reference' => $this->feedReference,
            'framework' => $this->framework,
            'group.alias' => $this->groupAlias?->toArray(),
            'group.id' => $this->groupId,
            'group.name' => $this->groupName,
            'group.reference' => $this->groupReference,
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
            'software.alias' => $this->softwareAlias?->toArray(),
            'software.id' => $this->softwareId,
            'software.name' => $this->softwareName,
            'software.platform' => $this->softwarePlatform?->toArray(),
            'software.reference' => $this->softwareReference,
            'software.type' => $this->softwareType?->value,
            'tactic.id' => $this->tacticId,
            'tactic.name' => $this->tacticName,
            'tactic.reference' => $this->tacticReference,
            'technique.id' => $this->techniqueId?->toArray(),
            'technique.name' => $this->techniqueName?->toArray(),
            'technique.reference' => $this->techniqueReference?->toArray(),
            'technique.subtechnique.id' => $this->techniqueSubtechniqueId?->toArray(),
            'technique.subtechnique.name' => $this->techniqueSubtechniqueName?->toArray(),
            'technique.subtechnique.reference' => $this->techniqueSubtechniqueReference?->toArray(),
            'indicator.as' => $this->indicatorAs?->getBody(),
            'indicator.file' => $this->indicatorFile?->getBody(),
            'indicator.geo' => $this->indicatorGeo?->getBody(),
            'indicator.registry' => $this->indicatorRegistry?->getBody(),
            'indicator.url' => $this->indicatorUrl?->getBody(),
            'indicator.x509' => $this->indicatorX509?->getBody(),
        ]);
    }
}
