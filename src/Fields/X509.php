<?php

namespace Hamidrezaniazi\Pecs\Fields;

use Carbon\Carbon;
use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-x509.html */
class X509 extends AbstractEcsField
{
    public function __construct(
        public readonly ?string $alternativeName = null,
        public readonly ?string $issuerCommonName = null,
        public readonly ?string $issuerCountry = null,
        public readonly ?string $issuerDistinguishedName = null,
        public readonly ?string $issuerLocality = null,
        public readonly ?string $issuerOrganization = null,
        public readonly ?string $issuerOrganizationalUnit = null,
        public readonly ?string $issuerStateOrProvince = null,
        public readonly ?Carbon $notAfter = null,
        public readonly ?Carbon $notBefore = null,
        public readonly ?string $publicKeyAlgorithm = null,
        public readonly ?string $publicKeyCurve = null,
        public readonly ?int $publicKeyExponent = null,
        public readonly ?int $publicKeySize = null,
        public readonly ?string $serialNumber = null,
        public readonly ?string $signatureAlgorithm = null,
        public readonly ?string $subjectCommonName = null,
        public readonly ?string $subjectCountry = null,
        public readonly ?string $subjectDistinguishedName = null,
        public readonly ?string $subjectLocality = null,
        public readonly ?string $subjectOrganization = null,
        public readonly ?string $subjectOrganizationalUnit = null,
        public readonly ?string $subjectStateOrProvince = null,
        public readonly ?string $versionNumber = null,
    ) {
        parent::__construct(false);
    }

    protected function key(): ?string
    {
        return 'x509';
    }

    protected function body(): Collection
    {
        return collect([
            'alternative_name' => $this->alternativeName,
            'issuer.common_name' => $this->issuerCommonName,
            'issuer.country' => $this->issuerCountry,
            'issuer.distinguished_name' => $this->issuerDistinguishedName,
            'issuer.locality' => $this->issuerLocality,
            'issuer.organization' => $this->issuerOrganization,
            'issuer.organizational_unit' => $this->issuerOrganizationalUnit,
            'issuer.state_or_province' => $this->issuerStateOrProvince,
            'not_after' => $this->notAfter?->toIso8601ZuluString(),
            'not_before' => $this->notBefore?->toIso8601ZuluString(),
            'public_key_algorithm' => $this->publicKeyAlgorithm,
            'public_key_curve' => $this->publicKeyCurve,
            'public_key_exponent' => $this->publicKeyExponent,
            'public_key_size' => $this->publicKeySize,
            'serial_number' => $this->serialNumber,
            'signature_algorithm' => $this->signatureAlgorithm,
            'subject.common_name' => $this->subjectCommonName,
            'subject.country' => $this->subjectCountry,
            'subject.distinguished_name' => $this->subjectDistinguishedName,
            'subject.locality' => $this->subjectLocality,
            'subject.organization' => $this->subjectOrganization,
            'subject.organizational_unit' => $this->subjectOrganizationalUnit,
            'subject.state_or_province' => $this->subjectStateOrProvince,
            'version_number' => $this->versionNumber,
        ]);
    }
}
