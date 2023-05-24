<?php

namespace Hamidrezaniazi\Pecs\Fields;

use Carbon\Carbon;
use Hamidrezaniazi\Pecs\Properties\Listables\EmailAttachmentList;
use Hamidrezaniazi\Pecs\Properties\ValueList;
use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-email.html */
class Email extends AbstractEcsField
{
    public function __construct(
        public readonly ?EmailAttachmentList $attachments = null,
        public readonly ?string $bccAddress = null,
        public readonly ?string $ccAddress = null,
        public readonly ?string $contentType = null,
        public readonly ?Carbon $deliveryTimestamp = null,
        public readonly ?string $direction = null,
        public readonly ?ValueList $fromAddress = null,
        public readonly ?string $localId = null,
        public readonly ?string $messageId = null,
        public readonly ?Carbon $originationTimestamp = null,
        public readonly ?ValueList $replyToAddress = null,
        public readonly ?string $senderAddress = null,
        public readonly ?string $subject = null,
        public readonly ?ValueList $toAddress = null,
        public readonly ?string $xMailer = null,
    ) {
        parent::__construct();
    }

    protected function key(): ?string
    {
        return 'email';
    }

    protected function body(): Collection
    {
        return collect([
            'attachments' => $this->attachments?->toArray(),
            'bcc.address' => $this->bccAddress,
            'cc.address' => $this->ccAddress,
            'content_type' => $this->contentType,
            'delivery_timestamp' => $this->deliveryTimestamp?->toIso8601ZuluString(),
            'direction' => $this->direction,
            'from.address' => $this->fromAddress?->toArray(),
            'local_id' => $this->localId,
            'message_id' => $this->messageId,
            'origination_timestamp' => $this->originationTimestamp?->toIso8601ZuluString(),
            'reply_to.address' => $this->replyToAddress?->toArray(),
            'sender.address' => $this->senderAddress,
            'subject' => $this->subject,
            'to.address' => $this->toAddress?->toArray(),
            'x_mailer' => $this->xMailer,
        ]);
    }
}
