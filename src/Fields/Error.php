<?php

namespace Hamidrezaniazi\Pecs\Fields;

use Hamidrezaniazi\Pecs\EcsFieldsCollection;
use Illuminate\Support\Collection;
use Throwable;

/** @link  https://www.elastic.co/guide/en/ecs/current/ecs-error.html */
class Error extends AbstractEcsField
{
    public function __construct(
        public readonly ?string $code = null,
        public readonly ?string $id = null,
        public readonly ?string $message = null,
        public readonly ?string $stackTrace = null,
        public readonly ?string $type = null,
        public readonly ?Throwable $throwable = null,
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

    public static function fromThrowable(Throwable $throwable): self
    {
        return new self(
            code: $throwable->getCode(),
            message: $throwable->getMessage(),
            stackTrace: $throwable->getTraceAsString(),
            type: get_class($throwable),
            throwable: $throwable,
        );
    }

    public function wrapper(): EcsFieldsCollection
    {
        return is_null($this->throwable)
            ? parent::wrapper()
            : parent::wrapper()->push(
                new Log(
                    originFileLine: $this->throwable->getLine(),
                    originFileName: $this->throwable->getFile(),
                ),
            );
    }
}
