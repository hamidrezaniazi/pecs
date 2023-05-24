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
        public readonly ?int $responseBytes = null,
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
            'request.body.bytes' => $this->requestBodyBytes,
            'request.body.content' => $this->requestBodyContent,
            'request.bytes' => $this->requestBytes,
            'request.id' => $this->requestId,
            'request.method' => $this->requestMethod?->value,
            'request.meme_type' => $this->requestMemeType,
            'request.referer' => $this->requestReferer,
            'response.body.bytes' => $this->responseBodyBytes,
            'response.body.content' => $this->responseBodyContent,
            'response.bytes' => $this->responseBytes,
            'response.meme_type' => $this->responseMemeType,
            'response.status_code' => $this->responseStatusCode,
            'version' => $this->version,
        ]);
    }
}
