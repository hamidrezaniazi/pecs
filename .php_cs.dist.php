<?php

require_once __DIR__ . '/vendor/autoload.php';

$finder = PhpCsFixer\Finder::create()
    ->exclude('vendor')
    ->in(__DIR__);

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR2' => true,
        'array_indentation' => true,
        'array_syntax' => ['syntax' => 'short'],
        'no_unused_imports' => true,
        'ordered_imports' => true,
        'blank_line_after_namespace' => true,
        'clean_namespace' => true,
        'compact_nullable_typehint' => true,
        'logical_operators' => true,
    ])
    ->setFinder($finder);
