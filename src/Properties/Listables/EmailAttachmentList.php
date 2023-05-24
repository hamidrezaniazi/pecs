<?php

namespace Hamidrezaniazi\Pecs\Properties\Listables;

use Hamidrezaniazi\Pecs\Fields\EmailAttachment;
use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-email.html#field-email-attachments */
class EmailAttachmentList
{
    /** @var Collection<string, EmailAttachment> */
    private Collection $list;

    public function __construct()
    {
        $this->list = new Collection();
    }

    public function toArray(): array
    {
        return $this->list->map(fn (EmailAttachment $item) => $item->toArray())->toArray();
    }

    public function push(EmailAttachment $value): self
    {
        $this->list->push($value);

        return $this;
    }
}
