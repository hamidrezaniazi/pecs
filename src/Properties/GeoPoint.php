<?php

namespace Hamidrezaniazi\Pecs\Properties;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-geo.html#field-geo-location */
class GeoPoint
{
    public function __construct(
        public readonly float $lat,
        public readonly float $lon,
    ) {}

    public function toArray(): array
    {
        return [
            'lat' => $this->lat,
            'lon' => $this->lon,
        ];
    }
}
