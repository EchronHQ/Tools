<?php
declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->exclude('vendor');

return (new PhpCsFixer\Config)
    ->setRules([
        '@PSR12' => true
    ])
    ->setUsingCache(false)
    ->setFinder($finder);

