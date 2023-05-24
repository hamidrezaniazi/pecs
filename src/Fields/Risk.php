<?php

namespace Hamidrezaniazi\Pecs\Fields;

use Hamidrezaniazi\Pecs\Properties\Percent;
use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-risk.html */
class Risk extends AbstractEcsField
{
    public function __construct(
        public readonly ?string $calculatedLevel = null,
        public readonly ?float $calculatedScore = null,
        public readonly ?Percent $calculatedScoreNorm = null,
        public readonly ?string $staticLevel = null,
        public readonly ?float $staticScore = null,
        public readonly ?Percent $staticScoreNorm = null,
    ) {
        parent::__construct(false);
    }

    protected function key(): ?string
    {
        return 'risk';
    }

    protected function body(): Collection
    {
        return collect([
            'calculated_level' => $this->calculatedLevel,
            'calculated_score' => $this->calculatedScore,
            'calculated_score_norm' => $this->calculatedScoreNorm?->value,
            'static_level' => $this->staticLevel,
            'static_score' => $this->staticScore,
            'static_score_norm' => $this->staticScoreNorm?->value,
        ]);
    }
}
