<?php

require __DIR__ . '/../vendor/autoload.php';

$configurator = new Nette\Configurator;
$configurator->setDebugMode(TRUE);
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
\Tracy\Debugger::$maxDepth = 10;


// Automatically build base row classes
$databaseClass = '\Filsedla\Hyperrow\SystemDatabase';

if (!class_exists($databaseClass) && $container->parameters['debugMode'] === TRUE) {
    $builder = $container->getByType('Filsedla\Hyperrow\RowClassesBuilder');
    $builder->build();
    //$loader->rebuild();
    echo "Hyperrow just generated a few classes. Please refresh the page.\n";
    exit;
}

$container->addService('SystemDatabase', $container->createInstance($databaseClass));


return $container;
