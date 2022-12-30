<?php

namespace Hamidrezaniazi\Pecs\Tests\Unit\Fields;

use Hamidrezaniazi\Pecs\Fields\Client;
use Hamidrezaniazi\Pecs\Tests\ReflectionHelpers;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    use ReflectionHelpers;

    public function testItShouldHaveItsKey(): void
    {
        $client = new Client();

        $this->assertEquals('client', $this->privateCall($client, 'key'));
        $this->assertEmpty($client->toArray());
    }

    public function testItShouldGenerateItsBody(): void
    {
        $address = 'example.domain';
        $bytes = 184;
        $domain = 'foo.example.com';
        $ip = '2001:db8:3333:4444:5555:6666:7777:8888';
        $mac = '00-00-5E-00-53-23';
        $natIp = '2002:db8:3333:4444:5555:6666:7777:9999';
        $natPort = 8080;
        $packets = 23;
        $port = 443;
        $registeredDomain = 'example.com';
        $subdomain = 'foo';
        $topLevelDomain = 'co.uk';

        $client = new Client(
            address: $address,
            bytes: $bytes,
            domain: $domain,
            ip: $ip,
            mac: $mac,
            natIp: $natIp,
            natPort: $natPort,
            packets: $packets,
            port: $port,
            registeredDomain: $registeredDomain,
            subdomain: $subdomain,
            topLevelDomain: $topLevelDomain,
        );

        $this->assertEquals(
            [
                'client' => [
                    'address' => $address,
                    'bytes' => $bytes,
                    'domain' => $domain,
                    'ip' => $ip,
                    'mac' => $mac,
                    'nat' => [
                        'ip' => $natIp,
                        'port' => $natPort,
                    ],
                    'packets' => $packets,
                    'port' => $port,
                    'registered_domain' => $registeredDomain,
                    'subdomain' => $subdomain,
                    'top_level_domain' => $topLevelDomain,
                ],
            ],
            $client->toArray(),
        );
    }
}
