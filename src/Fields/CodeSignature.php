<?php

namespace Hamidrezaniazi\Pecs\Fields;

use Carbon\Carbon;
use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-code_signature.html */
class CodeSignature extends AbstractEcsField
{
    public function __construct(
        public readonly ?string $digestAlgorithm = null,
        public readonly ?bool $exists = null,
        public readonly ?string $signingId = null,
        public readonly ?string $status = null,
        public readonly ?string $subjectName = null,
        public readonly ?string $teamId = null,
        public readonly ?Carbon $timestamp = null,
        public readonly ?bool $trusted = null,
        public readonly ?bool $valid = null,
    ) {
        parent::__construct(false);
    }

    protected function key(): ?string
    {
        return 'code_signature';
    }

    protected function body(): Collection
    {
        return collect([
            'digest_algorithm' => $this->digestAlgorithm,
            'exists' => $this->exists,
            'signing_id' => $this->signingId,
            'status' => $this->status,
            'subject_name' => $this->subjectName,
            'team_id' => $this->teamId,
            'timestamp' => $this->timestamp?->toIso8601ZuluString(),
            'trusted' => $this->trusted,
            'valid' => $this->valid,
        ]);
    }
}
