<?php

namespace Hamidrezaniazi\Pecs\Fields;

use Hamidrezaniazi\Pecs\Properties\Listables\PeSectionList;
use Hamidrezaniazi\Pecs\Properties\ValueList;
use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-pe.html */
class Pe extends AbstractEcsField
{
    public function __construct(
        public readonly ?string $architecture = null,
        public readonly ?string $company = null,
        public readonly ?string $description = null,
        public readonly ?string $fileVersion = null,
        public readonly ?string $goImportHash = null,
        public readonly ?ValueList $goImports = null,
        public readonly ?int $goImportsNamesEntropy = null,
        public readonly ?int $goImportsNamesVarEntropy = null,
        public readonly ?bool $goStripped = null,
        public readonly ?string $imphash = null,
        public readonly ?string $importHash = null,
        public readonly ?ValueList $imports = null,
        public readonly ?int $importsNamesEntropy = null,
        public readonly ?int $importsNamesVarEntropy = null,
        public readonly ?string $originalFileName = null,
        public readonly ?string $pehash = null,
        public readonly ?string $product = null,
        public readonly ?PeSectionList $sections = null,
    ) {
        parent::__construct(false);
    }

    protected function key(): ?string
    {
        return 'pe';
    }

    protected function body(): Collection
    {
        return collect([
            'architecture' => $this->architecture,
            'company' => $this->company,
            'description' => $this->description,
            'file_version' => $this->fileVersion,
            'go_import_hash' => $this->goImportHash,
            'go_imports' => $this->goImports?->toArray(),
            'go_imports_names_entropy' => $this->goImportsNamesEntropy,
            'go_imports_names_var_entropy' => $this->goImportsNamesVarEntropy,
            'go_stripped' => $this->goStripped,
            'imphash' => $this->imphash,
            'import_hash' => $this->importHash,
            'imports' => $this->imports?->toArray(),
            'imports_names_entropy' => $this->importsNamesEntropy,
            'imports_names_var_entropy' => $this->importsNamesVarEntropy,
            'original_file_name' => $this->originalFileName,
            'pehash' => $this->pehash,
            'product' => $this->product,
            'sections' => $this->sections?->toArray(),
        ]);
    }
}
