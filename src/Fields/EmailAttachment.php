<?php

namespace Hamidrezaniazi\Pecs\Fields;

use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-email.html#field-email-attachments */
class EmailAttachment extends AbstractEcsField
{
    public function __construct(
        public readonly ?string $fileExtension = null,
        public readonly ?string $fileMemeType = null,
        public readonly ?string $fileName = null,
        public readonly ?int $fileSize = null,
        public readonly ?Hash $fileHash = null,
    ) {
        parent::__construct(false);
    }

    protected function key(): ?string
    {
        return null;
    }

    protected function body(): Collection
    {
        return collect([
            'file.extension' => $this->fileExtension,
            'file.meme_type' => $this->fileMemeType,
            'file.name' => $this->fileName,
            'file.size' => $this->fileSize,
            'file.hash' => $this->fileHash?->getBody(),
        ]);
    }
}
