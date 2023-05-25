<?php

namespace Hamidrezaniazi\Pecs\Fields;

use Hamidrezaniazi\Pecs\Properties\Listables\DnsAnswerList;
use Hamidrezaniazi\Pecs\Properties\Listables\DnsHeaderFlagList;
use Hamidrezaniazi\Pecs\Properties\ValueList;
use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-dns.html */
class Dns extends AbstractEcsField
{
    public function __construct(
        public readonly ?DnsAnswerList $answers = null,
        public readonly ?DnsHeaderFlagList $headerFlags = null,
        public readonly ?string $id = null,
        public readonly ?string $opCode = null,
        public readonly ?string $questionClass = null,
        public readonly ?string $questionName = null,
        public readonly ?string $questionRegisteredDomain = null,
        public readonly ?string $questionSubdomain = null,
        public readonly ?string $questionTopLevelDomain = null,
        public readonly ?string $questionType = null,
        public readonly ?ValueList $resolvedIp = null,
        public readonly ?string $responseCode = null,
        public readonly ?string $type = null,
    ) {
        parent::__construct();
    }

    protected function key(): ?string
    {
        return 'dns';
    }

    protected function body(): Collection
    {
        return collect([
            'answers' => $this->answers?->toArray(),
            'header_flags' => $this->headerFlags?->toArray(),
            'id' => $this->id,
            'op_code' => $this->opCode,
            'question.class' => $this->questionClass,
            'question.name' => $this->questionName,
            'question.registered_domain' => $this->questionRegisteredDomain,
            'question.subdomain' => $this->questionSubdomain,
            'question.top_level_domain' => $this->questionTopLevelDomain,
            'question.type' => $this->questionType,
            'resolved_ip' => $this->resolvedIp?->toArray(),
            'response_code' => $this->responseCode,
            'type' => $this->type,
        ]);
    }
}
