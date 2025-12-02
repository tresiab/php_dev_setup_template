<?php

$finder = PhpCsFixer\Finder::create()
    // PHP-CS-Fixer will not scan or fix files that Git is ignoring
    ->ignoreVCSIgnored(true)
    // PHP-CS-Fixer not to scan or fix anything inside the vendor directory
    ->notPath('vendor')
    // tells PHP-CS-Fixer where to look for files it should format
    ->in(__DIR__);

return (new PhpCsFixer\Config())
    // setRiskyAllowed(true) enables rules in PHP-CS-Fixer that are considered "risky" because they might change how the code behaves — not just how it looks.
    ->setRiskyAllowed(true)
    ->setRules([
        // PHP standard recommended by PHP-FIG (Ensures consistent formatting [indentation, braces, spacing, etc.])
        '@PSR12' => true,
        // Symphony coding standard (More strict, cleaner formatting conventions)
        '@Symfony' => true,
        // Rule set from the fixer project itself (Adds many additional helpful formatting rules)
        '@PhpCsFixer' => true,
        // Makes code stricter with parameter declarations
        'strict_param' => true,
        // Forces one space around the '.' concatenation operator
        'concat_space' => ['spacing' => 'one'],

        // Optional: extra sugar
        // Sorts your 'use' imports alphabetically
        'ordered_imports' => ['sort_algorithm' => 'alpha'],
        // Converts double quotes to single quotes when no variables are needed
        'single_quote' => true,
        // Forces short array syntax: ['a', 'b'] instead of array('a', 'b')
        'array_syntax' => ['syntax' => 'short'],
        // Automatically removes unused 'use' statements.
        'no_unused_imports' => true,
    ])
    ->setFinder($finder);
