<?php

namespace Hamidrezaniazi\Pecs\Fields;

use Carbon\Carbon;
use Hamidrezaniazi\Pecs\Properties\Listables\GroupList;
use Hamidrezaniazi\Pecs\Properties\Listables\ProcessList;
use Hamidrezaniazi\Pecs\Properties\ValueList;
use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-process.html */
class Process extends AbstractEcsField
{
    public function __construct(
        public readonly ?ValueList $args = null,
        public readonly ?int $argsCount = null,
        public readonly ?string $commandLine = null,
        public readonly ?Carbon $end = null,
        public readonly ?string $entityId = null,
        public readonly ?string $entryMetaType = null,
        public readonly ?ValueList $envVars = null,
        public readonly ?string $executable = null,
        public readonly ?int $exitCode = null,
        public readonly ?bool $interactive = null,
        public readonly ?int $ioBytesSkippedLength = null,
        public readonly ?int $ioBytesSkippedOffset = null,
        public readonly ?bool $ioMaxBytesPerProcessExceeded = null,
        public readonly ?string $ioText = null,
        public readonly ?int $ioTotalBytesCaptured = null,
        public readonly ?int $ioTotalBytesSkipped = null,
        public readonly ?string $ioType = null,
        public readonly ?string $name = null,
        public readonly ?int $pgid = null,
        public readonly ?int $pid = null,
        public readonly ?bool $sameAsProcess = null,
        public readonly ?Carbon $start = null,
        public readonly ?int $threadId = null,
        public readonly ?string $threadName = null,
        public readonly ?string $title = null,
        public readonly ?int $ttyCharDeviceMajor = null,
        public readonly ?int $ttyCharDeviceMinor = null,
        public readonly ?int $ttyColumns = null,
        public readonly ?int $ttyRows = null,
        public readonly ?int $uptime = null,
        public readonly ?string $workingDirectory = null,
        public readonly ?GroupList $attestedGroups = null,
        public readonly ?User $attestedUser = null,
        public readonly ?CodeSignature $codeSignature = null,
        public readonly ?Elf $elf = null,
        public readonly ?Process $entryLeader = null,
        public readonly ?Process $entryLeaderParent = null,
        public readonly ?Process $entryLeaderParentSessionLeader = null,
        public readonly ?Source $entryMetaSource = null,
        public readonly ?Group $group = null,
        public readonly ?Process $groupLeader = null,
        public readonly ?Hash $hash = null,
        public readonly ?Macho $macho = null,
        public readonly ?Process $parent = null,
        public readonly ?Process $parentGroupLeader = null,
        public readonly ?Pe $pe = null,
        public readonly ?ProcessList $previous = null,
        public readonly ?Group $realGroup = null,
        public readonly ?User $realUser = null,
        public readonly ?Group $savedGroup = null,
        public readonly ?User $savedUser = null,
        public readonly ?Process $sessionLeader = null,
        public readonly ?Process $sessionLeaderParent = null,
        public readonly ?Process $sessionLeaderParentSessionLeader = null,
        public readonly ?GroupList $supplementalGroups = null,
        public readonly ?User $user = null,
    ) {
        parent::__construct();
    }

    protected function key(): ?string
    {
        return 'process';
    }

    protected function body(): Collection
    {
        return collect([
            'args' => $this->args?->toArray(),
            'args_count' => $this->argsCount,
            'command_line' => $this->commandLine,
            'end' => $this->end?->toIso8601ZuluString(),
            'entity_id' => $this->entityId,
            'entry_meta.type' => $this->entryMetaType,
            'env_vars' => $this->envVars?->toArray(),
            'executable' => $this->executable,
            'exit_code' => $this->exitCode,
            'interactive' => $this->interactive,
            'io.bytes_skipped.length' => $this->ioBytesSkippedLength,
            'io.bytes_skipped.offset' => $this->ioBytesSkippedOffset,
            'io.max_bytes_per_process_exceeded' => $this->ioMaxBytesPerProcessExceeded,
            'io.text' => $this->ioText,
            'io.total_bytes_captured' => $this->ioTotalBytesCaptured,
            'io.total_bytes_skipped' => $this->ioTotalBytesSkipped,
            'io.type' => $this->ioType,
            'name' => $this->name,
            'pgid' => $this->pgid,
            'pid' => $this->pid,
            'same_as_process' => $this->sameAsProcess,
            'start' => $this->start?->toIso8601ZuluString(),
            'thread.id' => $this->threadId,
            'thread.name' => $this->threadName,
            'title' => $this->title,
            'tty.char_device.major' => $this->ttyCharDeviceMajor,
            'tty.char_device.minor' => $this->ttyCharDeviceMinor,
            'tty.columns' => $this->ttyColumns,
            'tty.rows' => $this->ttyRows,
            'uptime' => $this->uptime,
            'working_directory' => $this->workingDirectory,
            'attested_groups' => $this->attestedGroups?->toArray(),
            'attested_user' => $this->attestedUser?->getBody(),
            'code_signature' => $this->codeSignature?->getBody(),
            'elf' => $this->elf?->getBody(),
            'entry_leader' => $this->entryLeader?->getBody(),
            'entry_leader.parent' => $this->entryLeaderParent?->getBody(),
            'entry_leader.parent.session_leader' => $this->entryLeaderParentSessionLeader?->getBody(),
            'entry_meta.source' => $this->entryMetaSource?->getBody(),
            'group' => $this->group?->getBody(),
            'group_leader' => $this->groupLeader?->getBody(),
            'hash' => $this->hash?->getBody(),
            'macho' => $this->macho?->getBody(),
            'parent' => $this->parent?->getBody(),
            'parent.group_leader' => $this->parentGroupLeader?->getBody(),
            'pe' => $this->pe?->getBody(),
            'previous' => $this->previous?->toArray(),
            'real_group' => $this->realGroup?->getBody(),
            'real_user' => $this->realUser?->getBody(),
            'saved_group' => $this->savedGroup?->getBody(),
            'saved_user' => $this->savedUser?->getBody(),
            'session_leader' => $this->sessionLeader?->getBody(),
            'session_leader.parent' => $this->sessionLeaderParent?->getBody(),
            'session_leader.parent.session_leader' => $this->sessionLeaderParentSessionLeader?->getBody(),
            'supplemental_groups' => $this->supplementalGroups?->toArray(),
            'user' => $this->user?->getBody(),
        ]);
    }
}
