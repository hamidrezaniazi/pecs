<?php

namespace Hamidrezaniazi\Pecs\Fields;

use Carbon\Carbon;
use Hamidrezaniazi\Pecs\Properties\ValueList;
use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-tls.html */
class TLS extends AbstractEcsField
{
    public function __construct(
        public readonly ?string $cipher = null,
        public readonly ?string $clientCertificate = null,
        public readonly ?ValueList $clientCertificateChain = null,
        public readonly ?string $clientHashMd5 = null,
        public readonly ?string $clientHashSha1 = null,
        public readonly ?string $clientHashSha256 = null,
        public readonly ?string $clientIssuer = null,
        public readonly ?string $clientJa3 = null,
        public readonly ?Carbon $clientNotAfter = null,
        public readonly ?Carbon $clientNotBefore = null,
        public readonly ?string $clientServerName = null,
        public readonly ?string $clientSubject = null,
        public readonly ?ValueList $clientSupportedCiphers = null,
        public readonly ?string $curve = null,
        public readonly ?bool $established = null,
        public readonly ?string $nextProtocol = null,
        public readonly ?bool $resumed = null,
        public readonly ?string $serverCertificate = null,
        public readonly ?ValueList $serverCertificateChain = null,
        public readonly ?string $serverHashMd5 = null,
        public readonly ?string $serverHashSha1 = null,
        public readonly ?string $serverHashSha256 = null,
        public readonly ?string $serverIssuer = null,
        public readonly ?string $serverJa3s = null,
        public readonly ?Carbon $serverNotAfter = null,
        public readonly ?Carbon $serverNotBefore = null,
        public readonly ?string $serverSubject = null,
        public readonly ?string $version = null,
        public readonly ?string $versionProtocol = null,
        public readonly ?X509 $clientX509 = null,
        public readonly ?X509 $serverX509 = null,
    ) {
        parent::__construct();
    }

    protected function key(): ?string
    {
        return 'tls';
    }

    protected function body(): Collection
    {
        return collect([
            'cipher' => $this->cipher,
            'client.certificate' => $this->clientCertificate,
            'client.certificate_chain' => $this->clientCertificateChain?->toArray(),
            'client.hash.md5' => $this->clientHashMd5,
            'client.hash.sha1' => $this->clientHashSha1,
            'client.hash.sha256' => $this->clientHashSha256,
            'client.issuer' => $this->clientIssuer,
            'client.ja3' => $this->clientJa3,
            'client.not_after' => $this->clientNotAfter?->toIso8601ZuluString(),
            'client.not_before' => $this->clientNotBefore?->toIso8601ZuluString(),
            'client.server_name' => $this->clientServerName,
            'client.subject' => $this->clientSubject,
            'client.supported_ciphers' => $this->clientSupportedCiphers?->toArray(),
            'curve' => $this->curve,
            'established' => $this->established,
            'next_protocol' => $this->nextProtocol,
            'resumed' => $this->resumed,
            'server.certificate' => $this->serverCertificate,
            'server.certificate_chain' => $this->serverCertificateChain?->toArray(),
            'server.hash.md5' => $this->serverHashMd5,
            'server.hash.sha1' => $this->serverHashSha1,
            'server.hash.sha256' => $this->serverHashSha256,
            'server.issuer' => $this->serverIssuer,
            'server.ja3s' => $this->serverJa3s,
            'server.not_after' => $this->serverNotAfter?->toIso8601ZuluString(),
            'server.not_before' => $this->serverNotBefore?->toIso8601ZuluString(),
            'server.subject' => $this->serverSubject,
            'version' => $this->version,
            'version_protocol' => $this->versionProtocol,
            'client.x509' => $this->clientX509?->getBody(),
            'server.x509' => $this->serverX509?->getBody(),
        ]);
    }
}
