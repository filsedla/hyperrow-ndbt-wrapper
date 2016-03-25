<?php

require __DIR__ . '/../vendor/autoload.php';

\Tracy\Debugger::$maxLen = 5000;
\Tracy\Debugger::$maxDepth = 6;

// Tester\Environment::setup();

$configurator = new Nette\Configurator;
//$configurator->setDebugMode(FALSE);
$configurator->enableDebugger(__DIR__ . '/../log');
$configurator->setTempDirectory(__DIR__ . '/../temp');

$loader = $configurator->createRobotLoader();
$loader->addDirectory(__DIR__ . '/../app')
    ->addDirectory(__DIR__ . '/../../src')
    ->register();

$configurator->addConfig(__DIR__ . '/../app/config/config.neon');
$configurator->addConfig(__DIR__ . '/../app/config/config.local.neon');

return $configurator->createContainer();
