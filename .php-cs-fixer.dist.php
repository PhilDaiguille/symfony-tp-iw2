<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude('var')
;

return (new PhpCsFixer\Config())
    ->setParallelConfig(PhpCsFixer\Runner\Parallel\ParallelConfigFactory::detect())
    ->setRules([
        '@Symfony' => true,
        'yoda_style' => true,
        'array_syntax' => ['syntax' => 'short'],
        'single_quote' => true,
    ])

    ->setFinder($finder)
;
