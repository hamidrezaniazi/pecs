<?php

namespace Hamidrezaniazi\Pecs\Fields;

use Hamidrezaniazi\Pecs\Properties\HttpMethod;
use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-http.html */
class Http extends AbstractEcsField
{
    public function __construct(
        public readonly ?int $requestBodyBytes = null,
        public readonly ?string $requestBodyContent = null,
        public readonly ?int $requestBytes = null,
        public readonly ?string $requestId = null,
        public readonly ?HttpMethod $requestMethod = null,
        public readonly ?string $requestMemeType = null,
        public readonly ?string $requestReferer = null,
        public readonly ?int $responseBodyBytes = null,
        public readonly ?string $responseBodyContent = null,
        public readonly ?int $responseByte = null,
        public readonly ?string $responseMemeType = null,
        public readonly ?int $responseStatusCode = null,
        public readonly ?string $version = null,
    ) {
        parent::__construct();
    }

    protected function key(): ?string
    {
        return 'http';
    }

    protected function body(): Collection
    {
        return collect([
            'request' => [
                'body' => [
                    'bytes' => $this->requestBodyBytes,
                    'content' => $this->requestBodyContent,
                ],
                'bytes' => $this->requestBytes,
                'id' => $this->requestId,
                'method' => $this->requestMethod?->value,
                'meme_type' => $this->requestMemeType,
                'referer' => $this->requestReferer,
            ],
            'response' => [
                'body' => [
                    'bytes' => $this->responseBodyBytes,
                    'content' => $this->responseBodyContent,
                ],
                'byte' => $this->responseByte,
                'meme_type' => $this->responseMemeType,
                'status_code' => $this->responseStatusCode,
            ],
            'version' => $this->version,
        ]);
    }
}
