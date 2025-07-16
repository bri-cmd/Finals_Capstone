<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

return new Config()
    ->setRules([
        '@PSR12' => true,
        'array_indentation' => true,
        'binary_operator_spaces' => ['default' => 'align'],
    ])
    ->setFinder(
        Finder::create()->in(__DIR__)
    );
