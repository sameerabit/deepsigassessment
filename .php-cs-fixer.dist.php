<?php


$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__ . '/src');

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12' => true,                // Use the PSR-12 coding standard
        'array_syntax' => ['syntax' => 'short'],  // Use short array syntax
        'binary_operator_spaces' => ['default' => 'align_single_space_minimal'], // Align binary operators
        'no_unused_imports' => true,     // Remove unused use statements
        'single_quote' => true,          // Enforce single quotes for strings
        'trailing_comma_in_multiline' => true,  // Add trailing comma in multiline arrays
        'blank_line_after_namespace' => true,
        "line_ending" => true,
        "no_whitespace_before_comma_in_array" => true,
        "trailing_comma_in_multiline" => true,
        "array_indentation" => true
    ])
    ->setFinder($finder);
