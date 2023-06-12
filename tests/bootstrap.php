<?php

/** @var \Composer\Autoload\ClassLoader $classLoader */
$classLoader = require 'vendor/autoload.php';


$classLoader->addClassMap([
    \PHPUnit\Metadata\Metadata::class             => __DIR__ . '/../vendor/phpunit/phpunit/src/Metadata/Metadata.php',
    \PHPUnit\Metadata\Api\DataProvider::class     => __DIR__ . '/../vendor/phpunit/phpunit/src/Metadata/Api/DataProvider.php',
    \PHPUnit\Metadata\Parser\Registry::class      => __DIR__ . '/../vendor/phpunit/phpunit/src/Metadata/Parser/Registry.php',
    \PHPUnit\Metadata\Parser\CachingParser::class => __DIR__ . '/../vendor/phpunit/phpunit/src/Metadata/Parser/CachingParser.php',
    \PHPUnit\Metadata\Parser\Parser::class        => __DIR__ . '/../vendor/phpunit/phpunit/src/Metadata/Parser/Parser.php',
    \PHPUnit\Metadata\Parser\ParserChain::class   => __DIR__ . '/../vendor/phpunit/phpunit/src/Metadata/Parser/ParserChain.php',
]);

//$classLoader->addPsr4('\\PHPUnit\\Metadata\\Api\\', __DIR__ . '/../vendor/phpunit/phpunit/src/Metadata/Api');


$classLoader->register();
