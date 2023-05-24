<?php

namespace Hamidrezaniazi\Pecs\Fields;

use Hamidrezaniazi\Pecs\Properties\Listables\MachoSectionList;
use Hamidrezaniazi\Pecs\Properties\ValueList;
use Illuminate\Support\Collection;

/** @link https://www.elastic.co/guide/en/ecs/current/ecs-macho.html */
class Macho extends AbstractEcsField
{
    public function __construct(
        public readonly ?string $goImportHash = null,
        public readonly ?ValueList $goImports = null,
        public readonly ?int $goImportsNamesEntropy = null,
        public readonly ?int $goImportsNamesVarEntropy = null,
        public readonly ?bool $goStripped = null,
        public readonly ?string $importHash = null,
        public readonly ?ValueList $imports = null,
        public readonly ?int $importsNamesEntropy = null,
        public readonly ?int $importsNamesVarEntropy = null,
        public readonly ?MachoSectionList $sections = null,
        public readonly ?string $symhash = null,
    ) {
        parent::__construct(false);
    }

    protected function key(): ?string
    {
        return 'macho';
    }

    protected function body(): Collection
    {
        return collect([
            'go_import_hash' => $this->goImportHash,
            'go_imports' => $this->goImports?->toArray(),
            'go_imports_names_entropy' => $this->goImportsNamesEntropy,
            'go_imports_names_var_entropy' => $this->goImportsNamesVarEntropy,
            'go_stripped' => $this->goStripped,
            'import_hash' => $this->importHash,
            'imports' => $this->imports?->toArray(),
            'imports_names_entropy' => $this->importsNamesEntropy,
            'imports_names_var_entropy' => $this->importsNamesVarEntropy,
            'sections' => $this->sections?->toArray(),
            'symhash' => $this->symhash,
        ]);
    }
}
