<?php

require __DIR__ . '/../vendor/autoload.php';

\Tracy\Debugger::$maxLen = 5000;
\Tracy\Debugger::$maxDepth = 6;

$configurator = new Nette\Configurator;
//$configurator->setDebugMode(TRUE);
$configurator->enableDebugger(__DIR__ . '/../log');
$configurator->setTempDirectory(__DIR__ . '/../temp');

$loader = $configurator->createRobotLoader();
$loader->addDirectory(__DIR__)
    ->addDirectory(__DIR__ . '/../../src')
    ->register();

$configurator->addConfig(__DIR__ . '/config/config.neon');
$configurator->addConfig(__DIR__ . '/config/config.local.neon');

$container = $configurator->createContainer();


// Generator can be run either this way or separately (tools/generate.php)
if ($container->parameters['debugMode'] === TRUE) {
    $generator = $container->createService('hyperrow.generator');
    $generator->generate();
    if ($generator->isChanged()) {
        echo "Hyperrow just generated a few classes. Please refresh the page.\n";
        exit;
    }
}

return $container;
