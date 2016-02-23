<?php

require __DIR__ . '/../vendor/autoload.php';

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

\Tracy\Debugger::$maxLen = 5000;
\Tracy\Debugger::$maxDepth = 6;


if ($container->parameters['debugMode'] === TRUE) {
    $generator = $container->getByType('Filsedla\Hyperrow\Generator');
    $generator->generate();
    if ($generator->isChanged()) {
        $loader->rebuild();
    }
}

return $container;
