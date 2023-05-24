<?php

namespace Hamidrezaniazi\Pecs\Fields;

use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-error.html */
class Error extends AbstractEcsField
{
    public function __construct(
        public readonly ?string $code = null,
        public readonly ?string $id = null,
        public readonly ?string $message = null,
        public readonly ?string $stackTrace = null,
        public readonly ?string $type = null,
    ) {
        parent::__construct();
    }

    protected function key(): ?string
    {
        return 'error';
    }

    protected function body(): Collection
    {
        return collect([
            'code' => $this->code,
            'id' => $this->id,
            'message' => $this->message,
            'stack_trace' => $this->stackTrace,
            'type' => $this->type,
        ]);
    }
}
