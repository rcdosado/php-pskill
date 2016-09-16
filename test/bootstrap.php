<?php

$autoloadFile = __DIR__ . '/../vendor/autoload.php';
if (!file_exists($autoloadFile)) {
    throw new RuntimeException('Install dependencies to run test suite.');
}
require_once $autoloadFile;

$loader = new \Composer\Autoload\ClassLoader();
$loader->add('PsKillWrapper\Test', 'Test');
$loader->register();
