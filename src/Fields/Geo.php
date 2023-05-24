<?php

namespace Hamidrezaniazi\Pecs\Fields;

use Carbon\CarbonTimeZone;
use Hamidrezaniazi\Pecs\Properties\GeoPoint;
use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-geo.html */
class Geo extends AbstractEcsField
{
    public function __construct(
        public readonly ?string $cityName = null,
        public readonly ?string $continentCode = null,
        public readonly ?string $continentName = null,
        public readonly ?string $countryIsoCode = null,
        public readonly ?string $countryName = null,
        public readonly ?GeoPoint $location = null,
        public readonly ?string $name = null,
        public readonly ?string $postalCode = null,
        public readonly ?string $regionIsoCode = null,
        public readonly ?string $regionName = null,
        public readonly ?CarbonTimeZone $timezone = null,
    ) {
        parent::__construct(false);
    }

    protected function key(): ?string
    {
        return 'geo';
    }

    protected function body(): Collection
    {
        return collect([
            'city_name' => $this->cityName,
            'continent_code' => $this->continentCode,
            'continent_name' => $this->continentName,
            'country_iso_code' => $this->countryIsoCode,
            'country_name' => $this->countryName,
            'location' => $this->location?->toArray(),
            'name' => $this->name,
            'postal_code' => $this->postalCode,
            'region_iso_code' => $this->regionIsoCode,
            'region_name' => $this->regionName,
            'timezone' => $this->timezone?->toRegionName(),
        ]);
    }
}
