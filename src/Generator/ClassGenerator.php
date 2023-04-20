<?php

namespace Hamidrezaniazi\Pecs\Generator;

use JsonException;
use RuntimeException;

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
        'resource',
        'null',
    ];

    public function __construct(
        private readonly string $configPath = __DIR__ . '/../../config/fields',
        private readonly string $storingPath = __DIR__ . '/../../src/Fields',
        private readonly string $namespace = 'Hamidrezaniazi\Pecs\Fields',
    ) {}

    /**
     * @throws JsonException
     */
    public function generate(): void
    {
        $paths = $this->getPaths();
        foreach ($paths as $path) {
            $config = $this->getConfig($path);
            $field = Field::parse($config);
            $classCode = $this->createClass($field);
            $this->storeClass($field->class, $classCode);
        }
    }

    private function createClass(Field $field): string
    {
        $imports = [];
        $constructor = [];

        foreach ($field->properties as $properties) {
            $castTypes = array_map(fn (string $type) =>  basename(str_replace('\\', '/', $type)), $properties->types);
            $cast = implode('|', array_diff($castTypes, ['nullable']));
            $nullable = in_array('nullable', $properties->types, true) ? '?' : '';
            $default = $nullable === '?' ? ' = null' : '';
            $constructor[] = "public readonly {$nullable}{$cast} \${$this->toCamelCase($properties->name)}{$default},";

            $importableTypes  = array_diff($properties->types, $this->nativeTypes, ['nullable', '']);
            foreach ($importableTypes as $importableType) {
                $imports[] = $importableType;
            }
        }

        // TODO change this to php-cs-fixer custom rule
        usort($constructor, function ($a, $b) {
            $aNull = (str_contains($a, '= null'));
            $bNull = (str_contains($b, '= null'));
            if ($aNull && !$bNull) {
                return 1;
            } elseif (!$aNull && $bNull) {
                return -1;
            } else {
                return 0;
            }
        });

        $properties = implode(PHP_EOL, array_map(function (Property $properties) {
            $cast = $properties->cast ? "?->{$properties->cast}()" : '';
            return "'{$properties->key}' => \$this->{$this->toCamelCase($properties->name)}{$cast},";
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
                '{{ $key }}',
                '{{ $properties }}',
            ],
            [
                "namespace {$this->namespace};",
                $importsCode,
                $field->documentLink,
                $field->class,
                implode(PHP_EOL, $constructor),
                $field->key ? "'{$field->key}'" : 'null',
                $properties,
            ],
            $this->getStub()
        );
    }

    /**
     * @return  FieldSchema
     * @throws JsonException
     */
    private function getConfig(string $path): array
    {
        $json = file_get_contents($path);
        if ($json === false) {
            throw new RuntimeException('Could not read base.json');
        }

        return json_decode($json, true, 512, JSON_THROW_ON_ERROR);
    }

    private function getStub(): string
    {
        $stub = file_get_contents(__DIR__ . '/field.stub');

        if ($stub === false) {
            throw new RuntimeException('Could not read stub');
        }

        return $stub;
    }

    private function storeClass(string $class, string $classCode): void
    {
        if (!is_dir($this->storingPath)) {
            mkdir($this->storingPath, 0755, true);
        }
        $dir = $this->storingPath . "/{$class}.php";
        file_put_contents($dir, $classCode);
        exec("../vendor/bin/php-cs-fixer fix --config=.php_cs.dist.php --quiet {$dir}");
    }

    /**
     * @return array<int, string>
     */
    private function getPaths(): array
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
}
