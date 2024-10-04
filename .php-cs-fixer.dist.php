<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude('var')
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
        'yoda_style' => true,
        'array_syntax' => ['syntax' => 'short']
    ])

    ->setFinder($finder)
;
