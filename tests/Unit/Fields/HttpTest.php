<?php

namespace Hamidrezaniazi\Pecs\Tests\Unit\Fields;

use Hamidrezaniazi\Pecs\Fields\Http;
use Hamidrezaniazi\Pecs\Properties\HttpMethod;
use Hamidrezaniazi\Pecs\Tests\ReflectionHelpers;
use Hamidrezaniazi\Pecs\Tests\Unit\UnitTestHelper;
use PHPUnit\Framework\TestCase;

class HttpTest extends TestCase
{
    use ReflectionHelpers;
    use UnitTestHelper;

    public function testItShouldHaveItsKey(): void
    {
        $http = new Http();

        $this->assertEquals('http', $this->privateCall($http, 'key'));
        $this->assertEmpty($http->toArray());
    }

    public function testItShouldGenerateItsBody(): void
    {
        $requestBodyBytes = 887;
        $requestBodyContent = 'Hello world';
        $requestBytes = 1437;
        $requestId = '123e4567-e89b-12d3-a456-426614174000';
        $requestMethod = $this->random(HttpMethod::cases());
        $requestMemeType = 'image/gif';
        $requestReferer = 'https://blog.example.com/';
        $responseBodyBytes = 123;
        $responseBodyContent = 'Test Content';
        $responseByte = 4321;
        $responseMemeType = 'image/jpg';
        $responseStatusCode = 404;
        $version = '1.1';


        $http = new Http(
            requestBodyBytes: $requestBodyBytes,
            requestBodyContent: $requestBodyContent,
            requestBytes: $requestBytes,
            requestId: $requestId,
            requestMethod: $requestMethod,
            requestMemeType: $requestMemeType,
            requestReferer: $requestReferer,
            responseBodyBytes: $responseBodyBytes,
            responseBodyContent: $responseBodyContent,
            responseByte: $responseByte,
            responseMemeType: $responseMemeType,
            responseStatusCode: $responseStatusCode,
            version: $version,
        );

        $this->assertEquals(
            [
                'http' => [
                    'request' => [
                        'body' => [
                            'bytes' => $requestBodyBytes,
                            'content' => $requestBodyContent,
                        ],
                        'bytes' => $requestBytes,
                        'id' => $requestId,
                        'method' => $requestMethod->value,
                        'meme_type' => $requestMemeType,
                        'referer' => $requestReferer,
                    ],
                    'response' => [
                        'body' => [
                            'bytes' => $responseBodyBytes,
                            'content' => $responseBodyContent,
                        ],
                        'byte' => $responseByte,
                        'meme_type' => $responseMemeType,
                        'status_code' => $responseStatusCode,
                    ],
                    'version' => $version,
                ],
            ],
            $http->toArray(),
        );
    }
}
