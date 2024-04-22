<?php

declare(strict_types=1);

use Rector\Config;
use Rector\Config\RectorConfig;
use Rector\TypeDeclaration\Rector\ClassMethod\AddVoidReturnTypeWhereNoReturnRector;
use Rector\TypeDeclaration\Rector\Property\TypedPropertyFromStrictConstructorRector;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/assets',
        __DIR__ . '/config',
        __DIR__ . '/public',
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
    // uncomment to reach your current PHP version
    ->withPhpSets()
    ->withRules([
        AddVoidReturnTypeWhereNoReturnRector::class,
        TypedPropertyFromStrictConstructorRector::class,
    ])

    ->withPreparedSets(
        deadCode: true,
        codeQuality: true
    );

// return static function (Config\RectorConfig $rectorConfig): void {
//     $rectorConfig->import('vendor/fakerphp/faker/rector-migrate.php');
// };