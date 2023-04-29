<?php

namespace Hamidrezaniazi\Pecs\Tests\Unit\Properties;

use Hamidrezaniazi\Pecs\Properties\GeoPoint;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Hamidrezaniazi\Pecs\Properties\GeoPoint
 */
class GeoPointTest extends TestCase
{
    public function testItCanCreateGeoPoint(): void
    {
        $geoPoint = new GeoPoint(-73.614830, 45.505918);
        $this->assertEquals([
            'lat' => -73.614830,
            'lon' => 45.505918,
        ], $geoPoint->toArray());
    }
}
