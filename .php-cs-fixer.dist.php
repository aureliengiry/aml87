<?php

declare(strict_types=1);

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude(['var', 'bin', 'node_modules']) // vendor already excluded in Finder()
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
        '@Symfony:risky' => true,
        '@PHP74Migration' => true,
        '@PHP74Migration:risky' => true,
        'array_syntax' => ['syntax' => 'short'],
        'full_opening_tag' => false,
        'array_indentation' => true,
        'logical_operators' => true,
        'mb_str_functions' => false,
        'multiline_whitespace_before_semicolons' => ['strategy' => 'no_multi_line'],
        'native_constant_invocation' => true,
        'native_function_invocation' => true,
        'no_useless_return' => true,
        'not_operator_with_space' => true,
        'ordered_imports' => true,
        'phpdoc_order' => true,
    ])
    ->setFinder($finder);
