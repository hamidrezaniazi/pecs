<?php

namespace Hamidrezaniazi\Pecs\Fields;

use Carbon\Carbon;
use Hamidrezaniazi\Pecs\Properties\Listables\FileAttributeList;
use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-file.html */
class File extends AbstractEcsField
{
    public function __construct(
        public readonly ?Carbon $accessed = null,
        public readonly ?FileAttributeList $attributes = null,
        public readonly ?Carbon $created = null,
        public readonly ?Carbon $ctime = null,
        public readonly ?string $device = null,
        public readonly ?string $driveLetter = null,
        public readonly ?string $extension = null,
        public readonly ?string $forkName = null,
        public readonly ?string $gid = null,
        public readonly ?string $group = null,
        public readonly ?string $inode = null,
        public readonly ?string $mimeType = null,
        public readonly ?string $mode = null,
        public readonly ?Carbon $mtime = null,
        public readonly ?string $name = null,
        public readonly ?string $owner = null,
        public readonly ?string $path = null,
        public readonly ?int $size = null,
        public readonly ?string $targetPath = null,
        public readonly ?string $type = null,
        public readonly ?string $uid = null,
        public readonly ?CodeSignature $codeSignature = null,
        public readonly ?Elf $elf = null,
        public readonly ?Hash $hash = null,
        public readonly ?Macho $macho = null,
        public readonly ?Pe $pe = null,
        public readonly ?X509 $x509 = null,
    ) {
        parent::__construct();
    }

    protected function key(): ?string
    {
        return 'file';
    }

    protected function body(): Collection
    {
        return collect([
            'accessed' => $this->accessed?->toIso8601ZuluString(),
            'attributes' => $this->attributes?->toArray(),
            'created' => $this->created?->toIso8601ZuluString(),
            'ctime' => $this->ctime?->toIso8601ZuluString(),
            'device' => $this->device,
            'drive_letter' => $this->driveLetter,
            'extension' => $this->extension,
            'fork_name' => $this->forkName,
            'gid' => $this->gid,
            'group' => $this->group,
            'inode' => $this->inode,
            'mime_type' => $this->mimeType,
            'mode' => $this->mode,
            'mtime' => $this->mtime?->toIso8601ZuluString(),
            'name' => $this->name,
            'owner' => $this->owner,
            'path' => $this->path,
            'size' => $this->size,
            'target_path' => $this->targetPath,
            'type' => $this->type,
            'uid' => $this->uid,
            'code_signature' => $this->codeSignature?->getBody(),
            'elf' => $this->elf?->getBody(),
            'hash' => $this->hash?->getBody(),
            'macho' => $this->macho?->getBody(),
            'pe' => $this->pe?->getBody(),
            'x509' => $this->x509?->getBody(),
        ]);
    }
}
