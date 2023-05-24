<?php

namespace Hamidrezaniazi\Pecs\Fields;

use Carbon\Carbon;
use Hamidrezaniazi\Pecs\Properties\Listables\ElfSectionList;
use Hamidrezaniazi\Pecs\Properties\Listables\ElfSegmentList;
use Hamidrezaniazi\Pecs\Properties\ValueList;
use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-elf.html */
class Elf extends AbstractEcsField
{
    public function __construct(
        public readonly ?string $architecture = null,
        public readonly ?string $byteOrder = null,
        public readonly ?string $cpuType = null,
        public readonly ?Carbon $creationDate = null,
        public readonly ?ValueList $exports = null,
        public readonly ?string $goImportHash = null,
        public readonly ?ValueList $goImports = null,
        public readonly ?int $goImportsNamesEntropy = null,
        public readonly ?int $goImportsNamesVarEntropy = null,
        public readonly ?bool $goStripped = null,
        public readonly ?string $headerAbiVersion = null,
        public readonly ?string $headerClass = null,
        public readonly ?string $headerData = null,
        public readonly ?int $headerEntrypoint = null,
        public readonly ?string $headerObjectVersion = null,
        public readonly ?string $headerOsAbi = null,
        public readonly ?string $importHash = null,
        public readonly ?ValueList $imports = null,
        public readonly ?int $importsNamesEntropy = null,
        public readonly ?int $importsNamesVarEntropy = null,
        public readonly ?ElfSectionList $sections = null,
        public readonly ?ElfSegmentList $segments = null,
        public readonly ?ValueList $sharedLibraries = null,
        public readonly ?string $telfhash = null,
    ) {
        parent::__construct();
    }

    protected function key(): ?string
    {
        return 'elf';
    }

    protected function body(): Collection
    {
        return collect([
            'architecture' => $this->architecture,
            'byte_order' => $this->byteOrder,
            'cpu_type' => $this->cpuType,
            'creation_date' => $this->creationDate?->toIso8601ZuluString(),
            'exports' => $this->exports?->toArray(),
            'go_import_hash' => $this->goImportHash,
            'go_imports' => $this->goImports?->toArray(),
            'go_imports_names_entropy' => $this->goImportsNamesEntropy,
            'go_imports_names_var_entropy' => $this->goImportsNamesVarEntropy,
            'go_stripped' => $this->goStripped,
            'header.abi_version' => $this->headerAbiVersion,
            'header.class' => $this->headerClass,
            'header.data' => $this->headerData,
            'header.entrypoint' => $this->headerEntrypoint,
            'header.object_version' => $this->headerObjectVersion,
            'header.os_abi' => $this->headerOsAbi,
            'import_hash' => $this->importHash,
            'imports' => $this->imports?->toArray(),
            'imports_names_entropy' => $this->importsNamesEntropy,
            'imports_names_var_entropy' => $this->importsNamesVarEntropy,
            'sections' => $this->sections?->toArray(),
            'segments' => $this->segments?->toArray(),
            'shared_libraries' => $this->sharedLibraries?->toArray(),
            'telfhash' => $this->telfhash,
        ]);
    }
}
