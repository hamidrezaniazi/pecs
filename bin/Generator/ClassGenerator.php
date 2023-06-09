<?php

namespace Hamidrezaniazi\Pecs\Bin\Generator;

use JsonException;
use RuntimeException;
use Throwable;

use function Hamidrezaniazi\Pecs\std_out_write;

/**
 * @phpstan-import-type FieldSchema from Field
 */
class ClassGenerator
{
    private array $nativeTypes = [
        'string',
        'int',
        'float',
        'bool',
        'array',
        'callable',
        'iterable',
        'object',
        'mixed',
        'null',
    ];

    public function __construct(
        private readonly string $configPath = __DIR__ . '/../../config/fields',
        private readonly string $fieldsStoringPath = __DIR__ . '/../../src/Fields',
        private readonly string $fieldsNamespace = 'Hamidrezaniazi\Pecs\Fields',
        private readonly string $listablesStoringPath = __DIR__ . '/../../src/Properties/Listables',
        private readonly string $listablesNamespace = 'Hamidrezaniazi\Pecs\Properties\Listables',
    ) {
    }

    /**
     * @throws JsonException
     */
    public function clean(): void
    {
        $paths = $this->getSchemaPaths();
        foreach ($paths as $path) {
            $config = $this->getConfig($path);
            $field = Field::parse($config);
            $this->deleteClass($field->class);

            if ($field->listable) {
                $this->deleteListableClass($field->class);
            }
        }
    }

    /**
     * @throws JsonException
     */
    public function generate(): void
    {
        $paths = $this->getSchemaPaths();

        std_out_write(count($paths) . ' schemas have been found to generate the classes...');

        foreach ($paths as $path) {
            $config = $this->getConfig($path);
            $field = Field::parse($config);

            std_out_write($field->class);

            $classCode = $this->createClass($field);
            $this->storeClass($field->class, $classCode);

            if ($field->listable) {
                $listableClassCode = $this->createListableClass($field);
                $this->storeListableClass($field->class, $listableClassCode);
            }
        }
    }

    private function createClass(Field $field): string
    {
        $imports = [];
        $constructor = [];

        foreach ($field->properties as $property) {
            $castTypes = array_map(fn (string $type) => basename(str_replace('\\', '/', $type)), $property->types);
            $cast = implode('|', array_diff($castTypes, ['nullable']));
            $nullable = $property->isNullable() ? '?' : '';
            $default = $property->default ? " = '{$property->default}'" : ($nullable ? ' = null' : '');
            $constructor[] = "public readonly {$nullable}{$cast} \${$this->toCamelCase($property->name)}{$default},";

            $importableTypes = array_diff($property->types, $this->nativeTypes, ['nullable', '']);
            foreach ($importableTypes as $importableType) {
                $imports[] = $importableType;
            }
        }

        // TODO change this to php-cs-fixer custom rule
        usort($constructor, function ($a, $b) {
            $aNull = (str_contains($a, '='));
            $bNull = (str_contains($b, '='));
            if ($aNull && !$bNull) {
                return 1;
            } elseif (!$aNull && $bNull) {
                return -1;
            } else {
                return 0;
            }
        });

        $properties = implode(PHP_EOL, array_map(function (Property $property) {
            $nullable = $property->isNullable() ? '?' : '';
            $cast = $property->cast ? "{$nullable}->{$property->cast}()" : '';
            $cast = $property->extract ? $cast . "?->{$property->extract}" : $cast;
            return "'{$property->key}' => \$this->{$this->toCamelCase($property->name)}{$cast},";
        }, $field->properties));

        $importsCode = implode(PHP_EOL, array_map(function ($import) {
            return "use {$import};";
        }, array_unique($imports)));

        return str_replace(
            [
                '{{ $namespace }}',
                '{{ $imports }}',
                '{{ $document_link }}',
                '{{ $class }}',
                '{{ $constructor }}',
                '{{ $rootable }}',
                '{{ $key }}',
                '{{ $properties }}',
            ],
            [
                "namespace {$this->fieldsNamespace};",
                $importsCode,
                $field->documentLink,
                $field->class,
                implode(PHP_EOL, $constructor),
                !$field->rootable ? 'false' : '',
                $field->key ? "'{$field->key}'" : 'null',
                $properties,
            ],
            $this->getFieldStub()
        );
    }

    /**
     * @return  FieldSchema
     * @throws JsonException
     */
    private function getConfig(string $path): array
    {
        try {
            $file = file_get_contents($path);

            if ($file === false) {
                throw new RuntimeException("Could not read {$path}");
            }

            /** @var FieldSchema $json */
            $json = json_decode($file, true, 512, JSON_THROW_ON_ERROR);
        } catch (Throwable) {
            throw new JsonException("Could not parse {$path}");
        }

        return $json;
    }

    private function getFieldStub(): string
    {
        $stub = file_get_contents(__DIR__ . '/field.stub');

        if ($stub === false) {
            throw new RuntimeException('Could not read stub');
        }

        return $stub;
    }

    private function storeClass(string $class, string $classCode): void
    {
        if (!is_dir($this->fieldsStoringPath)) {
            mkdir($this->fieldsStoringPath, 0755, true);
        }
        $dir = $this->getStoringDir($class);
        file_put_contents($dir, $classCode);
        $phpcsConfig = __DIR__ . '/../../.php_cs.dist.php';
        exec("../vendor/bin/php-cs-fixer fix --config={$phpcsConfig} --quiet {$dir}");
    }

    /**
     * @return array<int, string>
     */
    private function getSchemaPaths(): array
    {
        $paths = [];
        $files = scandir($this->configPath);
        if ($files === false) {
            throw new RuntimeException('Could not read config directory');
        }

        foreach ($files as $file) {
            if (str_ends_with($file, '.json')) {
                $paths[] = $this->configPath . '/' . $file;
            }
        }

        return $paths;
    }

    private function toCamelCase(string $string): string
    {
        $string = str_replace('.', '_', $string);
        $result = str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));

        return lcfirst($result);
    }

    private function deleteClass(string $class): void
    {
        unlink($this->getStoringDir($class));
    }

    private function getStoringDir(string $class): string
    {
        return $this->fieldsStoringPath . "/{$class}.php";
    }

    private function createListableClass(Field $field): string
    {
        return str_replace(
            [
                '{{ $namespace }}',
                '{{ $import }}',
                '{{ $document_link }}',
                '{{ $class }}',
            ],
            [
                "namespace {$this->listablesNamespace};",
                "use {$this->fieldsNamespace}\\{$field->class};",
                $field->documentLink,
                $field->class,
            ],
            $this->getListableStub()
        );
    }

    private function getListableStub(): string
    {
        $stub = file_get_contents(__DIR__ . '/listable.stub');

        if ($stub === false) {
            throw new RuntimeException('Could not read stub');
        }

        return $stub;
    }

    private function storeListableClass(string $class, string $listableClassCode): void
    {
        if (!is_dir($this->listablesStoringPath)) {
            mkdir($this->listablesStoringPath, 0755, true);
        }
        $dir = $this->listablesStoringPath . "/{$class}List.php";
        file_put_contents($dir, $listableClassCode);
        $phpcsConfig = __DIR__ . '/../../.php_cs.dist.php';
        exec("../vendor/bin/php-cs-fixer fix --config={$phpcsConfig} --quiet {$dir}");
    }

    private function deleteListableClass(string $class): void
    {
        unlink($this->listablesStoringPath . "/{$class}List.php");
    }
}
